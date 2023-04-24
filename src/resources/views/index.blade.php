<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <title>Media-manager</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,500&display=swap" rel="stylesheet">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- bootstrap 5.1.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


    <style>
        .media_files_preview{
            margin-top: 15px;
            border: 1px solid #aaa;
            padding: 10px;
            border-radius: 8px;
            min-height: 230px;
            max-height: 600px;
            overflow: auto;
        }
        .path_container{
            display: flex;
            justify-content: space-between;
        }
        #path{
            list-style-type: none;
            padding: 0;
            margin: 15px 0;
            display: flex;
            justify-content: flex-start;
        }
        #media_elements_container{
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
        }
        .folder_navigate_first{
            padding-right: 10px;
            font-weight: bold;
        }

        .folder_navigate{
            cursor: pointer;
        }
        .folder_navigate:hover {
            text-decoration: underline;
        }

        .slash{
            padding: 0 4px;
        }

        .card{
            margin: 10px;
        }

        .btn:focus, .btn:active, .btn-close:focus {
            outline: none;
            box-shadow: none !important;
        }

        .card-img-top{
            background: url(/bg.png);
            background-size: cover;
            width: 100%;
            height: 100%;
            max-width: 222px;
            max-height: 140px;
            object-fit: contain;
        }

        .media_items_controls_container{
            width: 100%;
            height: 100%;
            max-width: 222px;
            max-height: 140px;
            position: absolute;
        }

        .media_items_controls{
            opacity: 0;
            background-color: #000000bd;
            background-image: url(/dots.svg);
            background-size: 30px;
            background-position: center;
            width: 30px;
            height: 34px;
            border-radius: 8px;
            position: absolute;
            right: 3px;
            top: 3px;
            cursor: pointer;
            transition: all 0.5s;
            z-index: 1;
        }

        .media_items_controls_container:hover .media_items_controls{
            opacity: 1;
        }

        .dropdown-menu{
            font-size: 15px;
        }

        .dropdown-toggle{
            width: 100%;
            height: 100%;
        }

        .card-body {
            padding: 10px;
            max-height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-text{
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }

        .folder_name:hover{
            cursor: pointer;
            text-decoration: underline;
        }

    </style>

</head>

<body style="padding: 10px">


{{-- Modal создание папки --}}
<div class="modal fade" id="add_folder" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавить папку</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="new_folder_name" class="form-control" placeholder="Название папки">
                <div class="alert alert-danger" role="alert" id="create_folder_alert" style="margin-top: 10px; display: none"></div>
            </div>
            <div class="modal-footer">
                <button type="button" id="close_create" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" id="save_new_folder">Добавить</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Переименования папки --}}
<div class="modal fade" id="renameModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактировать</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="rename_type" value="">
                <input type="hidden" id="old_name" value="">
                <input type="text" id="new_name" class="form-control" value="">
                <div class="alert alert-danger" role="alert" id="rename_alert" style="margin-top: 10px; display: none"></div>
            </div>
            <div class="modal-footer">
                <button type="button" id="close_rename" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" id="rename_btn">Сохранить</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Удаления --}}
<div class="modal fade" id="removeModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Удалить</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="remove_type" value="">
                <input type="hidden" id="to_remove" value="">
                <p id="remove_name"></p>
            </div>
            <div class="modal-footer">
                <button type="button" id="close_remove" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-danger" id="remove_btn">Удалить</button>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <h3>Media-manager</h3>


    {{-- Загрузчик файлов --}}
    <form method="POST" id="files" action="/mediamanager/uploadFiles" accept-charset="UTF-8" enctype="multipart/form-data">

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Файлы</label>
                    <input class="form-control" name="files[]" id="files_input" type="file" multiple>
                </div>
            </div>
            <div class="col-md-2" style="display: flex; align-items: flex-end;">
                <div class="mb-3">
                    <button type="submit" id="upload_files" class="btn btn-success">Сохранить</button>
                </div>
            </div>
        </div>

    </form>


    <div class="path_container">
        <ul id="path">
            <li class="folder_navigate_first">Текущая директория: </li>
            <li class="folder_navigate" data-folder_name="media" onclick="folderNavigate(this)">media / </li>
        </ul>

        <button class="btn btn-success" style="height: fit-content" data-bs-toggle="modal" data-bs-target="#add_folder">Добавить папку</button>

    </div>
    <div class="media_files_preview">
        {{-- Просмотр файлов --}}

        <ul id="media_elements_container">
            @foreach($directories as $directory)
                @php
                    $directory = explode('/',$directory);
                    $name = end($directory);
                @endphp
                <li class="card" style="width: 14rem;">
                    <div class="media_items_controls_container">
                        <div class="dropdown media_items_controls">
                            <div class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"></div>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                <li><span class="dropdown-item rename-btn" data-bs-toggle="modal" data-bs-target="#renameModal" data-title="{{ $name }}"
                                          data-rename_type="folder" onclick="rename(this)">Редактировать</span></li>
                                <li><span class="dropdown-item rename-btn" data-bs-toggle="modal" data-bs-target="#removeModal" data-title="{{ $name }}"
                                          data-remove_type="folder" onclick="remove(this)">Удалить</span></li>
                            </ul>
                        </div>
                    </div>
                    <img class="card-img-top" src="folders.png">
                    <div class="card-body">
                        <p class="card-text folder_name" data-folder_name="{{ $name }}" onclick="folderNavigate(this)">{{ $name }}</p>
                    </div>
                </li>
            @endforeach

            @foreach($files as $file)
                @php
                $src = '';
                    switch ($file->ext){
                        case 'png':
                        case 'jpg':
                        case 'svg':
                            $src = $file->pathFromPublic;
                            break;
                        case 'zip':
                        case 'rar':
                            $src = 'archive.png';
                            break;
                        case 'txt':
                            $src = 'txt.png';
                            break;
                        default:
                            $src = 'file.png';
                            break;
                    }
                @endphp

                <li class="card" style="width: 14rem;">
                    <div class="media_items_controls_container">
                        <div class="dropdown media_items_controls">
                            <div class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"></div>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                <li><span class="dropdown-item rename-btn" data-bs-toggle="modal" data-bs-target="#renameModal" data-title="{{ $file->getFilename() }}"
                                          data-rename_type="file" onclick="rename(this)">Редактировать</span></li>
                                <li><a class="dropdown-item" href="#">Информация</a></li>
                                <li><span class="dropdown-item rename-btn" data-bs-toggle="modal" data-bs-target="#removeModal" data-title="{{ $file->getFilename() }}"
                                          data-remove_type="file" onclick="remove(this)">Удалить</span></li>
                            </ul>
                        </div>
                    </div>
                    <img class="card-img-top" src="{{ $src }}">
                    <div class="card-body">
                        <p class="card-text">{{ $file->getFilename() }}</p>
                    </div>
                </li>
            @endforeach


        </ul>


    </div>

</div>
</body>

<script>

    let current_path = 'media';

    // сохранение новой папки
    document.querySelector('#save_new_folder').addEventListener('click', function () {
        let folder_name = document.querySelector('#new_folder_name').value.trim();

        // Валидация имени папки
        if ( folder_name === '') {
            document.querySelector("#create_folder_alert").innerHTML = 'Название не может быть пустым';
            document.querySelector("#create_folder_alert").style.display = "block";
            setTimeout(() => document.querySelector("#create_folder_alert").style.display = "none", 3500);
            return false;
        } else {
                // Запрос на создание папки
                let data = new FormData();
                data.append('current_path', current_path);
                data.append('folder_name', folder_name);

                let xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {

                        let res = JSON.parse(this.responseText);

                        if(res.status === 'error'){
                            document.querySelector("#create_folder_alert").innerHTML = res.msg;
                            document.querySelector("#create_folder_alert").style.display = "block";
                            setTimeout(() => document.querySelector("#create_folder_alert").style.display = "none", 3500);
                        }

                        if(res.status === 'success'){
                            openFolder(current_path); // перерисовка файлов и папок директории
                            document.querySelector('#close_create').dispatchEvent(new Event("click")); // закрытие модалки
                            document.querySelector('#new_folder_name').value = '';
                        }

                    } else {
                        console.log(this);
                    }
                }
                xhr.open('POST', '/mediamanager/createFolder', false);
                xhr.setRequestHeader('x-csrf-token', '{{ csrf_token() }}');
                xhr.send(data);

            }
    });

    // Определить путь к папке
    function folderNavigate(element)
    {
        let path_to_folder;
        if(element.classList.contains('folder_name')){
            // Если нажали на папку в списке файлов
            path_to_folder = current_path + '/' + element.getAttribute('data-folder_name');
        }

        if(element.classList.contains('folder_navigate')) {
            // Если нажали на папку в навигации
            let selected_folder = element.getAttribute('data-folder_name');
            path_to_folder = 'media';
            if (selected_folder !== 'media'){
                for (let item of document.querySelectorAll('.folder_navigate')) {
                    if (item.getAttribute('data-folder_name') === 'media') { continue; }
                    path_to_folder += '/' + item.getAttribute('data-folder_name');
                    if (item.getAttribute('data-folder_name') === selected_folder) { break; }
                }
            }
        }

       openFolder(path_to_folder);
    }


    function rename(element){
        document.querySelector("#rename_type").value = element.getAttribute('data-rename_type');
        document.querySelector("#old_name").value = element.getAttribute('data-title');
        document.querySelector("#new_name").value = element.getAttribute('data-title');
    }

    // Переименование
    document.querySelector('#rename_btn').onclick = function (){

        if(document.querySelector("#old_name").value === document.querySelector("#new_name").value){
            document.querySelector("#rename_alert").innerHTML = 'Название не изменено';
            document.querySelector("#rename_alert").style.display = "block";
            setTimeout(() => document.querySelector("#rename_alert").style.display = "none", 3500);
            return false;
        }
        if( document.querySelector("#new_name").value.trim() === ''){
            document.querySelector("#rename_alert").innerHTML = 'Название должно содержать как минимум 1 символ';
            document.querySelector("#rename_alert").style.display = "block";
            setTimeout(() => document.querySelector("#rename_alert").style.display = "none", 3500);
            return false;
        }

        let data = new FormData();
        data.append('rename_type', document.querySelector("#rename_type").value);
        data.append('old_name', document.querySelector("#old_name").value);
        data.append('new_name', document.querySelector("#new_name").value);
        data.append('current_path', current_path);

        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {

                let res = JSON.parse(this.responseText);
                console.log(res);
                if(res.status === 'error'){
                    document.querySelector("#rename_alert").innerHTML = res.msg;
                    document.querySelector("#rename_alert").style.display = "block";
                    setTimeout(() => document.querySelector("#rename_alert").style.display = "none", 3500);
                }
                if(res.status === 'success'){
                    openFolder(current_path);
                    document.querySelector('#close_rename').dispatchEvent(new Event("click")); // закрытие модалки
                }

            } else {
                console.log(this);
            }
        }
        xhr.open('POST', '/mediamanager/updateMedia', false);
        xhr.setRequestHeader('x-csrf-token', '{{ csrf_token() }}');
        xhr.send(data);
    };


    function remove(element){
        document.querySelector("#remove_type").value = element.getAttribute('data-remove_type');
        document.querySelector("#to_remove").value = element.getAttribute('data-title');
        document.querySelector("#remove_name").innerHTML = 'Удалить ' + element.getAttribute('data-title') + ' ?';
    }

    // Удаление
    document.querySelector('#remove_btn').onclick = function (){
        let data = new FormData();
        data.append('remove_type', document.querySelector("#remove_type").value);
        data.append('to_remove', document.querySelector("#to_remove").value);
        data.append('current_path', current_path);

        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {

                let res = JSON.parse(this.responseText);

                if(res.status === 'success'){
                    document.querySelector('#close_remove').dispatchEvent(new Event("click")); // закрытие модалки
                    openFolder(current_path);
                }

            } else {
                console.log(this);
            }
        }
        xhr.open('POST', '/mediamanager/deleteMedia', false);
        xhr.setRequestHeader('x-csrf-token', '{{ csrf_token() }}');
        xhr.send(data);
    }


    // Переход в папку. Получение списка файлов и папок
    function openFolder(path_to_folder){
        let data = new FormData();
        data.append('path_to_folder', path_to_folder);

        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {

                let res = JSON.parse(this.responseText);

                updateList(res);

            } else {
                console.log(this);
            }
        }
        xhr.open('POST', '/mediamanager/openFolder', false);
        xhr.setRequestHeader('x-csrf-token', '{{ csrf_token() }}');
        xhr.send(data);
    }

    // Отрисовка папок и файлов выбранной директории
    function updateList(res){

        let folders = res.path_to_folder.split('/');
        let route = `<li class="folder_navigate_first">Текущая директория: </li>`;
        for (let folder of folders){
            route += `<li class="folder_navigate" data-folder_name="${folder}" onclick="folderNavigate(this)">${folder} / </li>`
        }
        document.querySelector('#path').innerHTML = route;
        current_path = res.path_to_folder;


        if( res.directories.length === 0 && res.files.length === 0){
            document.querySelector('#media_elements_container').innerHTML = `<h5>Папка пуста</h5>`;
            return true;
        }

        let directories = ``;
        for(let dir of res.directories){

            let arr = dir.split('/');
            let name = arr.slice(-1).pop();

            directories += `
            <li class="card" style="width: 14rem;">
            <div class="media_items_controls_container">
                <div class="dropdown media_items_controls">
                    <div class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"></div>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                        <li><span class="dropdown-item rename-btn" data-bs-toggle="modal" data-bs-target="#renameModal" data-title="${ name }"
                                  data-rename_type="folder" onclick="rename(this)">Редактировать</span></li>
                        <li><span class="dropdown-item rename-btn" data-bs-toggle="modal" data-bs-target="#removeModal" data-title="${ name }"
                                  data-remove_type="folder" onclick="remove(this)">Удалить</span></li>
                    </ul>
                </div>
            </div>
            <img class="card-img-top" src="folders.png">
                <div class="card-body">
                    <p class="card-text folder_name" data-folder_name="${ name }" onclick="folderNavigate(this)">${ name }</p>
                </div>
            </li>
            `;
        }

        let files = ``;
        for(let file of res.files){

            let arr = file.pathFromPublic.split('/');
            let name = arr.slice(-1).pop();

            let src = '';
            switch (file.ext){
                case 'png':
                case 'jpg':
                case 'svg':
                    src = file.pathFromPublic;
                    break;
                case 'zip':
                case 'rar':
                    src = 'archive.png';
                    break;
                case 'txt':
                    src = 'txt.png';
                    break;
                default:
                    src = 'file.png';
                    break;
            }

            files += `
            <li class="card" style="width: 14rem;">
            <div class="media_items_controls_container">
                <div class="dropdown media_items_controls">
                    <div class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"></div>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                        <li><span class="dropdown-item rename-btn" data-bs-toggle="modal" data-bs-target="#renameModal" data-title="${ name }"
                                  data-rename_type="file" onclick="rename(this)">Редактировать</span></li>
                        <li><a class="dropdown-item" href="#">Информация</a></li>
                        <li><span class="dropdown-item rename-btn" data-bs-toggle="modal" data-bs-target="#removeModal" data-title="${ name }"
                                  data-remove_type="file" onclick="remove(this)">Удалить</span></li>
                    </ul>
                </div>
            </div>
            <img class="card-img-top" src="${ src }">
                <div class="card-body">
                    <p class="card-text">${ name }</p>
                </div>
            </li>
            `;
        }

        document.querySelector('#media_elements_container').innerHTML = directories + files;
    }

    document.querySelector('#upload_files').onclick = function(e){
        e.preventDefault();

        let form = document.querySelector('#files');
        let data = new FormData(form);
        data.append('current_path', current_path);

        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {

                let res = JSON.parse(this.responseText);

                if(res.status === 'success'){
                    openFolder(current_path);
                    document.querySelector('#files_input').value = '';
                }

            } else {
                console.log(this);
            }
        }
        xhr.open('POST', '/mediamanager/uploadFiles', false);
        xhr.setRequestHeader('x-csrf-token', '{{ csrf_token() }}');
        xhr.send(data);

    };


</script>


</html>
