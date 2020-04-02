create table playlist
(
    id int auto_increment
        primary key,
    name varchar(50) null
);

create table video
(
    id int auto_increment
        primary key,
    title varchar(50) not null,
    thumbnail varchar(255) not null
);

create table video_playlist
(
	video_id int not null,
	playlist_id int not null,
	position int not null,
	primary key (video_id, playlist_id, position),
	constraint video_playlist_playlist_id_fk
		foreign key (playlist_id) references playlist (id)
			on delete cascade,
	constraint video_playlist_video_id_fk
		foreign key (video_id) references video (id)
			on delete cascade
);
