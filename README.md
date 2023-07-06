## Book (LARAVEL REST API WITH SANCTUM AUTHENTICATION)

Some features of this REST api:

- Book model methods (index, store, update, delete, search)
- Custom Book, Login and User Requests for validation
- Custom Book and user resource and collection
- Custom HttpResponse Trait for returning json responses
- Custom Middleware (basic authentication thru header authorization)
- Eloquent observers of the Book model events(created, updated, deleted)
- With Auth methods for register, login, logout
- With Sanctum authentication

Steps for cloning this app:

- Create a new folder for this project
- Open terminal and initialize git (git init)
- git clone https://github.com/eradix/book.git
- composer install
- create .env file and setup your environment variables (db_name,ports, user and password)
- run the migration and seed (php artisan migrate:refresh --seed) so that there is a dummy data that can be test with
- serve the app (php artisan serve)

BOOK Rest API endpoints

BOOKS
- api/v2/books (GET) -> list all books
- api/v2/books (POST) -> stores a new book resource
- api/v2/books/{book} (GET) -> lists a particular book info
- api/v2/books/{book} (PUT) -> updates specified book resource
- api/v2/books/{book} (DELETE) -> deletes or remove specified book resource
- api/v2/books/search/{searchString} (GET) -> search a book via book title, description or author's name

AUTH/USER
- api/v2/login (POST) -> login the user and create a user's token
- api/v2/logout (POST) -> logging out the user and deletes his current token
- api/v2/register (POST)  -> stores new user resource and generate a user's token
  

Commits/Steps done:

- make migration, model, factories
- create a BooksController and all its resource method and a book resource and collection
- creates a custom request for validation and custom httpResponses Trait
- creates custom middleware (basic auth middleware)
-   add an eloquent observer (BookObserver) that logs data in created, updated and deleted events
- creates a login, logout, register functionality, also a UserResource and add sanctum authentication
- Create a book search functionality via title, description or name of the author

In progress work:

- Create AuthorController and all its resource method as well as resource and collection
- create a custom request (AuthorRequest) for validation
- add an eloquent observer (AuthorObserver) that logs data in created, updated and deleted events
- Create an author search functionality via first or last name of the author
- Create CategoryController and all its resource method as well as resource and collection
- create a custom request CategoryRequest) for validation
- add an eloquent observer (CategoryObserver) that logs data in created, updated and deleted events
- Create an Category search functionality via name of the category 
- Additional in AuthController. Add (update, destroy and search via name or email) methods


