/*Start database from command line:
  /usr/local/mysql/bin/mysqld&
*/

/*Create the database
CREATE DATABASE announcements;
*/

set sql_mode='';
set storage_engine=myisam;

/*Create tables*/
Use announcements;

/*drop table Category;*/
CREATE table if not exists Category ( Id int unsigned AUTO_INCREMENT not null, Name char(128) binary default '' not null, primary key Id (Id) ) engine=MyISAM CHARACTER set utf8 collate utf8_bin comment='Database privileges';

/*drop table Topic;*/
CREATE table if not exists Topic ( Id int unsigned AUTO_INCREMENT not null, Name char(128) binary default '' not null, primary key Id (Id) ) engine=MyISAM CHARACTER set utf8 collate utf8_bin comment='Database privileges';

/*drop table Announcements*/;
CREATE table if not exists Announcements ( Id int unsigned AUTO_INCREMENT not null, category_id int unsigned not null, topic_id int unsigned not null, Title char(128) binary default '' not null, Location char(128) binary default '', Content varchar(512) binary default '' not null, Datetime timestamp not null default current_timestamp, primary key Id (Id), foreign key (category_id) references Category(Id), foreign key (topic_id) references Topic(Id) ) engine=MyISAM CHARACTER set utf8 collate utf8_bin comment='Database privileges';

/*Add test data for Category
insert into Category (Name) values ('Clubs'), ('Sports'), ('Events');
*/


/*Add test data for Topic
insert into Topic (Name) values ('Computer Science'), ('Badminton'), ('Curling');
*/

/*Add test data for Announcement
insert into Announcements (category_id, topic_id, Title, Location, Content, Datetime) values (1, 1, 'This is a test', 'Lisgar CI', 'This is a test announcement', now());
*/

/*Sample query
select ans.Title as title, cat.Name as category, top.Name as topic, ans.Location as location, ans.Content as content, date(ans.Datetime) as date from Announcements as ans, Category as cat, Topic as top where ans.id='1' and ans.category_id=cat.id and ans.topic_id=top.id order by ans.DatetimeAnnouncements;
*/