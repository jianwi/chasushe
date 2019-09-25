create table if not exists chasu.room
(
    id       int auto_increment
        primary key,
    name     varchar(100)     null,
    prev     int              null,
    isDelete bit default b'0' null
);

create table if not exists chasu.room_check
(
    id         int auto_increment
        primary key,
    room_id    int                                 not null,
    crime      varchar(255)                        not null,
    cleangrade varchar(30)                         not null,
    comment    varchar(255)                        not null,
    teacher_id int                                 not null,
    pic        varchar(255)                        null,
    date       timestamp default CURRENT_TIMESTAMP not null,
    isDelete   bit       default b'0'              null
);

create table if not exists chasu.students_check
(
    id         int auto_increment
        primary key,
    student_id int                                 not null,
    teacher_id int                                 not null,
    crime      varchar(255)                        not null,
    date       timestamp default CURRENT_TIMESTAMP not null,
    isDelete   bit                                 not null
);

create table if not exists chasu.students_room
(
    id       int auto_increment
        primary key,
    room_id  int              not null,
    uid      int              not null,
    isDelete bit default b'0' not null
);

create table if not exists chasu.teacher
(
    id       int auto_increment
        primary key,
    name     varchar(30)                         not null,
    yb_uid   varchar(15)                         not null,
    phone    varchar(30)                         not null,
    extra    text                                null,
    date     timestamp default CURRENT_TIMESTAMP null,
    status   int(1)                              not null,
    isDelete bit       default b'0'              not null
);

create table if not exists chasu.user
(
    id       int auto_increment
        primary key,
    name     varchar(30)                         not null,
    major    varchar(255)                        null,
    college  varchar(255)                        null,
    yb_uid   varchar(30)                         not null,
    room_id  int                                 not null,
    date     timestamp default CURRENT_TIMESTAMP null,
    isDelete bit       default b'0'              null
);


