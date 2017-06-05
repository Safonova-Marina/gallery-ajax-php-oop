create database gallery;
use gallery;

create table images(
	id int(5) primary key auto_increment,
	comment varchar(200),
	weight int(4) NOT NULL,
	path varchar(100) NOT NULL,
	dateCreate datetime NOT NULL
);

INSERT INTO images (id, comment, weight, path, dateCreate) VALUES
(1, 'Image1. Barcelona. On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment', '548356', './images/02-05-2017-21-45-15.jpg', Now()),
(2, 'Image2. Beautiful red sea', '144272', './images/02-05-2017-21-45-25.jpg', Now()),
(3, 'Image3. Toskana', '281883', './images/02-05-2017-21-45-35.jpg', Now());


#create table images(id int(5) primary key auto_increment, comment varchar(200), weight int(4) NOT NULL, path varchar(100) NOT NULL, dateCreate datetime NOT NULL);