create table users (
    user_id serial primary key not null,
    email varchar(255) unique not null,
    password varchar(255) not null,
    created_on TIMESTAMP default current_timestamp,
    full_name varchar(255) not null
);

create table tasks (
    task_id serial primary key not null,
    user_id integer references users(user_id) not null,
    title varchar(255) not null,
    description text,
    start_time TIMESTAMP,
    end_time TIMESTAMP,
    due_date TIMESTAMP,
    created_on TIMESTAMP default current_timestamp,
    time_to_complete integer,
    completed boolean default false
);

insert into
    tasks (
        user_id,
        title,
        description,
        start_time,
        end_time,
        due_date,
        time_to_complete
    )
values
    (
        16,
        'homework #7',
        'CS 401',
        null,
        null,
        '2022-03-28',
        60
    );

-- create table users_tasks (
--     user_id integer not null,
--     task_id integer not null,
--     primary key (user_id, task_id)
-- );