select
  users.id as Id,
  concat(first_name, ' ', last_name) as Name,
  author as Author,
  group_concat(name SEPARATOR ', ') as Books
from user_books
  inner join users
    on age between 7 and 16
    and users.id IN (select user_id from user_books group by user_id having count(user_id) = 2)
    and users.id = user_books.user_id
  inner join books
    on books.id = user_books.book_id
group by users.id, first_name, last_name, author
having count(user_books.book_id) = 2