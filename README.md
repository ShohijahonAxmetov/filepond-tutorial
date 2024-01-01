Use **FilePond** in **Laravel** for beginners

File structure:

    routes\web.php - routes;

    app\Http\Controllers\FilePondController.php - handle **FilePond** methods;

    public\assets\scripts\* - **FilePond** scripts;
    public\assets\styles\* - **FilePond** styles;

    resources\views\components\filepond\styles.blade.php - **FilePond** styles for include to layout (_if you edit, then from here_)
    resources\views\components\filepond\scripts.blade.php - **FilePond** scripts for include to layout (_if you edit, then from here_)

    resources\views\welcome.blade.php - start view

_Don't forget to create a link for the storage folder_ (run command **php artisan storage:link**)
