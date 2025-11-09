# Corporate Car API

REST API для выбора и бронирования служебных автомобилей сотрудниками компании.

## Описание

Система позволяет сотруднику выбрать доступный служебный автомобиль на конкретный период времени,
учитывая категорию комфорта, закреплённого водителя и должностные ограничения.

---

## Стек технологий

  PHP 8.3+, Laravel 12, PostgreSQL, Eloquent ORM, JSON API (REST), DTO + Service + Resource architecture

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

## Настройка базы данных

    DB_CONNECTION=pgsql
    DB_HOST=postgres_db
    DB_PORT=5432
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=

---

## Пример запросов

    curl -X GET "http://127.0.0.1:8000/api/available-cars" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer 1|roW2W3t9KofuTcX8tcQHmhlFoqb0lypsgVsGemRd5305e3a0" \
    -G \
    --data-urlencode "start_time=2025-11-09 10:00:00" \
    --data-urlencode "end_time=2025-11-09 14:00:00"

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
- Controller — обработка входных запросов
