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
    ```bash
    # Клонирование репозитория
    git clone <repository-url>
    cd test
    
    # Установка зависимостей
    composer install
    npm install
    
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

    GET /api/available-cars
- email (string) - Email пользователя
- start_time (string) - Начало поездки
- end_time (string) - Конец поездки
- model_id (integer) - ID модели автомобиля
- category_id (integer) - ID категории комфорта

---

## Настройка базы данных

    ```bash
    DB_CONNECTION=pgsql
    DB_HOST=postgres_db
    DB_PORT=5432
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=

---

## Пример запросов
    ```bash
    GET /api/available-cars?email=manager@test.com&start_time=2025-11-08T10:00:00&end_time=2025-11-08T13:00:00

## Пример ответа 
    ```bash
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
