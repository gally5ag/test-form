# ER図

```mermaid
erDiagram
    USERS ||--o{ CONTACTS : "has"
    CATEGORIES ||--o{ CONTACTS : "classifies"

    USERS {
        bigint id PK
        varchar name
        varchar email
        varchar password
    }
    CONTACTS {
        bigint id PK
        bigint category_id FK
        varchar first_name
        varchar last_name
        tinyint gender
        varchar email
        varchar tel
        varchar address
        varchar building
        text detail
        timestamp created_at
        timestamp updated_at
    }
    CATEGORIES {
        bigint id PK
        varchar content
        timestamp created_at
        timestamp updated_at
    }
