/*Manage Apache & mySQL server from command line

-- Start, stop and restart Apache server
  > sudo apachectl start
  > sudo apachectl stop
  > sudo apachectl restart

-- check if the Apache server running
  > ps -ef|grep httpd

    0    86     1   0  4:04PM ??         0:00.50 /usr/sbin/httpd -D FOREGROUND
   70   214    86   0  4:04PM ??         0:00.00 /usr/sbin/httpd -D FOREGROUND
   70   215    86   0  4:04PM ??         0:00.00 /usr/sbin/httpd -D FOREGROUND
   70   216    86   0  4:04PM ??         0:00.00 /usr/sbin/httpd -D FOREGROUND
   70   217    86   0  4:04PM ??         0:00.00 /usr/sbin/httpd -D FOREGROUND
   70   218    86   0  4:04PM ??         0:00.00 /usr/sbin/httpd -D FOREGROUND
   70   493    86   0  4:06PM ??         0:00.00 /usr/sbin/httpd -D FOREGROUND
   70   497    86   0  4:06PM ??         0:00.00 /usr/sbin/httpd -D FOREGROUND
   70   498    86   0  4:06PM ??         0:00.00 /usr/sbin/httpd -D FOREGROUND

-- Start database from command line:
  > Login from root user
  > mysqld&

-- Check if the mySQL server running
  > ps -ef|grep mysqld

Terences-MacBook-Pro:~ ywlei$ ps -ef|grep mysql
  503 11371 11292   0  6:37PM ttys000    0:00.40 mysqld

- Kill the server
  > kill -9 11292

- List command history and re-run a command
  > history

  183  history
  184  mysqld&
  185  ps -ef|grep mysql
  186  cd /Users/Jenny/Documents/ISU-github/isu-jennylei/db/
  187  ls -al

  > !184

- Goto and List a directory
  > cd /Users/Jenny/Documents/ISU-github/isu-jennylei/db/
  > ls -al
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
select ans.Title as title, cat.Name as category, top.Name as topic, ans.Location as location, ans.Content as content, date(ans.Datetime) as date, month(ans.Datetime) as month from Announcements as ans, Category as cat, Topic as top where ans.id='1' and ans.category_id=cat.id and ans.topic_id=top.id order by ans.DatetimeAnnouncements;
/*/
