create table users (
	user_id serial primary key not null,
	email varchar(255) unique not null,
	password varchar(255) not null,
	created_on TIMESTAMP default current_timestamp,
	full_name varchar(255) not null
);

create table task (
    task_id serial primary key not null, -- primary key
    title varchar(255) not null, -- title of the task
    description varchar(255), -- description of the task
    created_on TIMESTAMP default current_timestamp, -- date the task was created
    due_date TIMESTAMP not null, -- date the task is due
    time_estimate int not null, -- estimated time to complete the task
    start_time TIMESTAMP, -- time the task started
    end_time TIMESTAMP, -- time the task ended
    completed boolean default false -- whether the task is completed
);

create table users_tasks (
    user_id integer not null,
    task_id integer not null,
    primary key (user_id, task_id)
);

