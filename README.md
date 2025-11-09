# Corporate Car API

REST API для выбора и бронирования служебных автомобилей сотрудниками компании.

## Описание

Система позволяет сотруднику выбрать доступный служебный автомобиль на конкретный период времени,
учитывая категорию комфорта, закреплённого водителя и должностные ограничения.

---

## Стек технологий

PHP 8.3+, Laravel 12, Laravel Sanctum, PostgreSQL, Eloquent ORM, JSON API (REST), DTO + Service + Resource architecture

---

##  Установка

    # Клонирование репозитория
    git clone <repository-url>
    cd test
    
    # Установка зависимостей
    composer install
    
    # Настройка окружения
    cp .env.example .env
    php artisan key:generate
    
    # Настройка базы данных
    php artisan migrate
    php artisan db:seed
    
    # Запуск сервера
    php artisan serve

---

## Настройка базы данных

    DB_CONNECTION=pgsql
    DB_HOST=postgres_db
    DB_PORT=5432
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=

---

## Эндпоинты 

    POST /api/register
- name (string) - Email пользователя
- email (string) - Email пользователя
- password (string) - Email пользователя

    POST /api/login
- email (string) - Email пользователя
- password (string) - Email пользователя

    GET /api/available-cars
- start_time (string) - Начало поездки
- end_time (string) - Конец поездки
- model_id (integer) - ID модели автомобиля
- category_id (integer) - ID категории комфорта

---

## Регистрация

POST /api/register
    Content-Type: application/json
    {
    "name": "Имя",
    "email": "user@example.com",
    "password": "password123"
    }

## Логин

POST /api/login
    Content-Type: application/json
    {
    "email": "user@example.com",
    "password": "password123"
    }

## Получение данных 

Headers:
    Accept: application/json
    Authorization: Bearer TOKEN_STRING
Query-параметры:
    filter[start_time]=YYYY-MM-DD HH:MM:SS
    filter[end_time]=YYYY-MM-DD HH:MM:SS
    filter[model_id]=OPTIONAL
    filter[category_id]=OPTIONAL

---

## Пример запросов

    curl -X GET "http://127.0.0.1:8000/api/available-cars" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer <TOKEN_STRING>" \
    -G \
    --data-urlencode "filter[start_time]=2025-11-09 10:00:00" \
    --data-urlencode "filter[end_time]=2025-11-09 14:00:00" \
    --data-urlencode "filter[model_id]=1" \
    --data-urlencode "filter[category_id]=2"

---

## Пример ответа 
    {
        "data": [
        {
            "id": 2,
            "reg_number": "B222BB",
            "model": {
                "id": 2,
                "name": "Skoda Octavia",
                "comfort_category": {
                    "id": 2,
                    "name": "Вторая"
                }
            },
            "driver": {
                "id": 2,
                "first_name": "Пётр",
                "last_name": "Петров",
                "employee_number": "DRV002"
            }
        },
       ],
       "count": 1
    }

---

## Архитектура проекта 

- DTO — передача данных между слоями
- Service — бизнес-логика фильтрации
- Resource — форматирование ответа API
- FormRequest — валидация данных
- Filters - фильтрация данных
- Controller — обработка входных запросов

--- 
 
## Структура проекта 

    app/
    ├── DTOs/
    │    └── CarDTO.php        
    ├── Filters/
    │    └── CarFilters.php      
    ├── Requests/
    │    └── AvailableCarsRequest.php   
    │    └── LoginRequest.php   
    │    └── RegisterRequest.php   
    ├── Resources/
    │    └── CarResources.php   
    ├── Services/
    │    └── CarService.php      
    ├── Http/
    │    └── Controllers/
    │       └── Api/
    │           └── CarController.php
    │           └── AuthController.php
