/* lay tat ca user va quyen cua user */
CREATE VIEW users AS
SELECT user.*, GROUP_CONCAT(DISTINCT permission.name SEPARATOR ',') as permissions 
FROM user
LEFT JOIN user_permisstion ON user.id = user_permisstion.user_id
LEFT JOIN permission ON user_permisstion.permission_id = permission.id
GROUP BY user.id;

/* lay tat ca danh muc va danh muc cha cua no (neu co) */
CREATE VIEW categories AS
SELECT category.*, parent.name as parent_name, parent.active as parent_active 
FROM category 
LEFT JOIN category parent ON category.parent_id = parent.id;

/* Lay tat ca bai viet */
CREATE VIEW articles AS
SELECT 	article.*, 
	category.name as category_name, 
        author.full_name as author_name, 
        reviewer.full_name as reviewer_name, 
        editor.full_name as editor_name, 
	GROUP_CONCAT(DISTINCT tag.name SEPARATOR ',') as tag_names,
        GROUP_CONCAT(DISTINCT tag.id SEPARATOR ',') as tag_ids 
FROM article
LEFT JOIN article_tag ON article.id = article_tag.article_id
LEFT JOIN tag ON article_tag.tag_id = tag.id
LEFT JOIN category ON article.category_id = category.id
LEFT JOIN user reviewer ON article.review_person_id = reviewer.id
LEFT JOIN user author ON article.author_id = author.id
LEFT JOIN user editor ON article.editor_id = editor.id
GROUP BY article.id
ORDER BY article.create_time DESC;

/* Lay bai viet da rv */
CREATE VIEW reviewed_articles AS
SELECT  article.*, 
        category.name as category_name, 
        author.full_name as author_name, 
        reviewer.full_name as reviewer_name, 
        editor.full_name as editor_name, 
        GROUP_CONCAT(DISTINCT tag.name SEPARATOR ',') as tag_names,
        GROUP_CONCAT(DISTINCT tag.id SEPARATOR ',') as tag_ids 
FROM article
LEFT JOIN article_tag ON article.id = article_tag.article_id
LEFT JOIN tag ON article_tag.tag_id = tag.id
LEFT JOIN category ON article.category_id = category.id
LEFT JOIN user author ON article.author_id = author.id
LEFT JOIN user editor ON article.editor_id = editor.id
INNER JOIN user reviewer ON article.review_person_id = reviewer.id
GROUP BY article.id
ORDER BY review_time DESC;

/* Lay bai viet da xuất bản */
CREATE VIEW published_articles AS
SELECT  article.*, 
        category.name as category_name, 
        author.full_name as author_name, 
        reviewer.full_name as reviewer_name, 
        editor.full_name as editor_name, 
        GROUP_CONCAT(DISTINCT tag.name SEPARATOR ',') as tag_names,
        GROUP_CONCAT(DISTINCT tag.id SEPARATOR ',') as tag_ids 
FROM article
LEFT JOIN article_tag ON article.id = article_tag.article_id
LEFT JOIN tag ON article_tag.tag_id = tag.id
LEFT JOIN category ON article.category_id = category.id
LEFT JOIN user reviewer ON article.review_person_id = reviewer.id
LEFT JOIN user author ON article.author_id = author.id
LEFT JOIN user editor ON article.editor_id = editor.id
WHERE published = 1
GROUP BY article.id
ORDER BY publish_time DESC, priority ASC;

DELIMITER $$
CREATE PROCEDURE getArticlesByUser(IN user_id INT)
BEGIN
        SELECT * FROM articles WHERE author_id = user_id ORDER BY create_time DESC;
END$$
DELIMITER ;

-- proc luu tin tuc moi
DELIMITER $$
CREATE PROCEDURE saveArticle(title varchar(255), description varchar(255), content mediumtext, image varchar(255), author_id int(11), category_id int(11), drafft bit(1), tag_ids varchar(255))
BEGIN
        START TRANSACTION;
            INSERT INTO article(title,description,content,image,author_id,category_id,drafft) VALUES (title,description,content,image,author_id,category_id,drafft);
            SET @id = LAST_INSERT_ID();
            SET @tag_ids = tag_ids;
            IF @tag_ids <> ""  THEN
                tag: WHILE true DO
                    SET @tag_id = SUBSTRING_INDEX(@tag_ids, ",", 1);
                    INSERT INTO article_tag(article_id, tag_id) VALUES (@id,CAST(@tag_id AS UNSIGNED));
                    IF @tag_ids <> @tag_id THEN
                        SET @tag_ids = SUBSTRING(@tag_ids,LENGTH(@tag_id)+2);
                    ELSE
                        LEAVE tag;
                    END IF;
                END WHILE;
            END IF;
            SELECT @id;
        COMMIT;
END$$
DELIMITER ;

-- trigger set tg tao tin tuc moi
DELIMITER $$
CREATE TRIGGER article_create_time
BEFORE INSERT ON article 
FOR EACH ROW
BEGIN
        SET new.create_time = NOW();
END$$
DELIMITER ;

-- proc update 1 tin tuc 
DELIMITER $$
CREATE PROCEDURE updateArticle(article_id INT, title varchar(255), description varchar(255), content mediumtext, image varchar(255), author_id int(11), category_id int(11), drafft bit(1), tag_ids varchar(255))
BEGIN
        START TRANSACTION;
            UPDATE article 
            SET title=title,
                description=description,
                content=content,
                image=image,
                author_id=author_id,
                category_id=category_id,
                drafft=drafft
            WHERE id = article_id;
            DELETE FROM article_tag WHERE article_tag.article_id=article_id;
            SET @tag_ids = tag_ids;
            IF @tag_ids <> ""  THEN
                tag: WHILE true DO
                    SET @tag_id = SUBSTRING_INDEX(@tag_ids, ",", 1);
                    INSERT INTO article_tag(article_id, tag_id) VALUES (article_id,CAST(@tag_id AS UNSIGNED));
                    IF @tag_ids <> @tag_id THEN
                        SET @tag_ids = SUBSTRING(@tag_ids,LENGTH(@tag_id)+2);
                    ELSE
                        LEAVE tag;
                    END IF;
                END WHILE;
            END IF;
        COMMIT;
END$$
DELIMITER ;

--proc delete article
DELIMITER $$
CREATE PROCEDURE deleteArticle(article_id INT) 
BEGIN 
        START TRANSACTION; 
                DELETE FROM article_tag WHERE article_tag.article_id = article_id; 
                DELETE FROM article WHERE id = article_id; 
        COMMIT; 
END$$
DELIMITER ;

-- trigger set update time
DELIMITER $$
CREATE TRIGGER article_update_time
BEFORE UPDATE ON article
FOR EACH ROW
BEGIN
    SET NEW.update_time = NOW();
END$$
DELIMITER ;

-- xuat ban 1 bai bao
DELIMITER $$
CREATE PROCEDURE publishArticles(article_ids varchar(255), editor_id int(11))
BEGIN
        START TRANSACTION;
            SET @publish_time = NOW();
            SET @priority = 1;
            SET @article_ids = article_ids;
            IF @article_ids <> ""  THEN
                tag: WHILE true DO
                    SET @article_id = SUBSTRING_INDEX(@article_ids, ",", 1);
                    UPDATE article 
                    SET editor_id=editor_id,
                        published=1, 
                        publish_time=@publish_time,
                        priority=@priority
                    WHERE id = @article_id;
                    SET @priority = @priority + 1;
                    IF @article_ids <> @article_id THEN
                        SET @article_ids = SUBSTRING(@article_ids,LENGTH(@article_id)+2);
                    ELSE
                        LEAVE tag;
                    END IF;
                END WHILE;
            END IF;
            SELECT @publish_time;
        COMMIT;
END$$
DELIMITER ;

-- time read
DELIMITER $$
CREATE TRIGGER article_read_time
BEFORE INSERT ON `read`
FOR EACH ROW
BEGIN
        SET new.time = NOW();
END$$
DELIMITER ;

-- read history
DELIMITER $$
CREATE PROCEDURE readArticle(article_id int(11), user_id int(11))
BEGIN
        START TRANSACTION;
            SET @read = EXISTS (SELECT * FROM `read` WHERE `read`.article_id = article_id AND `read`.user_id = user_id);
            IF @read <> 1 THEN
                INSERT INTO `read`(article_id,user_id) VALUES(article_id,user_id);
            END IF;
        COMMIT;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE reviewArticle(article_id int(11), review_person_id int(11), drafft bit(1))
BEGIN
        START TRANSACTION;
            SET @review_time = NULL;
            IF drafft = 0 THEN
                SET @review_time = NOW();
                UPDATE article 
                SET review_person_id=review_person_id,
                    review_time=@review_time,
                    drafft=drafft
                WHERE id = article_id;
            ELSE
                UPDATE article 
                SET drafft=drafft
                WHERE id = article_id;
            END IF;
            SELECT @review_time;
        COMMIT;
END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER cmt_update_time
BEFORE UPDATE ON comment
FOR EACH ROW
BEGIN
    SET NEW.update_time = NOW();
END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER cmt_create_time
BEFORE INSERT ON comment 
FOR EACH ROW
BEGIN
        SET new.create_time = NOW();
END$$
DELIMITER ;

CREATE VIEW comments AS
SELECT comment.*, user.username as user_username
FROM comment 
LEFT JOIN user ON comment.user_id = user.id
ORDER BY create_time DESC;

DELIMITER $$
CREATE PROCEDURE commentArticle(article_id int(11), user_id int(11), content text)
BEGIN
        START TRANSACTION;
            INSERT INTO comment(article_id, user_id, content) VALUES(article_id, user_id, content);
            SELECT * FROM comments WHERE id = LAST_INSERT_ID();
        COMMIT;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE likeArticle(article_id int(11), user_id int(11))
BEGIN
        START TRANSACTION;
            SET @liked = EXISTS (SELECT * FROM `like` WHERE `like`.article_id = article_id AND `like`.user_id = user_id);
            IF @liked = 1 THEN
                DELETE FROM `like` WHERE `like`.article_id = article_id AND `like`.user_id = user_id;
            ELSE
                INSERT INTO `like`(article_id,user_id) VALUES(article_id,user_id);
            END IF;
        COMMIT;
END$$
DELIMITER ;

CREATE VIEW hot_tags AS
select `article_management`.`tag`.`id` AS `id`, `article_management`.`tag`.`name` AS `name`, sum(`published_articles`.`view`) AS `view` 
from ((`article_management`.`tag` 
left join `article_management`.`article_tag` on(`article_management`.`tag`.`id` = `article_management`.`article_tag`.`tag_id`)) 
left join `article_management`.`published_articles` on(`published_articles`.`id` = `article_management`.`article_tag`.`article_id`)) 
where `published_articles`.`publish_time` >= current_timestamp() - interval 7 day 
group by `article_management`.`tag`.`id` 
order by sum(`published_articles`.`view`) desc;

DELIMITER $$
CREATE TRIGGER user_update_time
BEFORE UPDATE ON user
FOR EACH ROW
BEGIN
    SET NEW.update_time = NOW();
END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER user_create_time
BEFORE INSERT ON user 
FOR EACH ROW
BEGIN
        SET new.create_time = NOW();
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE updateUser(user_id INT, full_name varchar(45), email varchar(45), phone_number varchar(10), avatar_img varchar(255), superuser bit(1), perms varchar(255))
BEGIN
        START TRANSACTION;
            UPDATE user 
            SET full_name=full_name,
                email=email,
                phone_number=phone_number,
                avatar_img=avatar_img,
                super_user=superuser
            WHERE id = user_id;
            DELETE FROM user_permisstion WHERE user_permisstion.user_id=user_id;
            SET @perms = perms;
            IF @perms <> ""  THEN
                tag: WHILE true DO
                    SET @perm = SUBSTRING_INDEX(@perms, ",", 1);
                    INSERT INTO user_permisstion(user_id, permission_id) VALUES (user_id,CAST(@perm AS UNSIGNED));
                    IF @perms <> @perm THEN
                        SET @perms = SUBSTRING(@perms,LENGTH(@perm)+2);
                    ELSE
                        LEAVE tag;
                    END IF;
                END WHILE;
            END IF;
        COMMIT;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE newUser(username varchar(45), password varchar(45), full_name varchar(45), email varchar(45), phone_number varchar(10), avatar_img varchar(255), superuser bit(1), perms varchar(255))
BEGIN
        START TRANSACTION;
            INSERT INTO user(username,password,full_name,email,phone_number,avatar_img,super_user) VALUES(username,password,full_name,email,phone_number,avatar_img,super_user);
            SET @id = LAST_INSERT_ID();
            SET @perms = perms;
            IF @perms <> ""  THEN
                tag: WHILE true DO
                    SET @perm = SUBSTRING_INDEX(@perms, ",", 1);
                    INSERT INTO user_permisstion(user_id, permission_id) VALUES (@id,CAST(@perm AS UNSIGNED));
                    IF @perms <> @perm THEN
                        SET @perms = SUBSTRING(@perms,LENGTH(@perm)+2);
                    ELSE
                        LEAVE tag;
                    END IF;
                END WHILE;
            END IF;
        COMMIT;
END$$
DELIMITER ;

CREATE VIEW user_history AS
SELECT `read`.*, articles.*
FROM `read`
INNER JOIN articles ON `read`.`article_id` = articles.id
ORDER BY  `read`.`time` DESC;

CREATE VIEW user_like AS
SELECT `like`.*, articles.*
FROM `like`
INNER JOIN articles ON `like`.`article_id` = articles.id;