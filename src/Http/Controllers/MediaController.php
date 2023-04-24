<?php

namespace Shkiper\MediaManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $directories = File::directories(public_path('media'));
        $files = File::files(public_path('media'));

        $this->setFilesPath($files);

        return view('mediamanager::index', compact('directories', 'files'));
    }

    public function createFolder(Request $request)
    {
        $path = public_path($request->current_path . '/' . $request->folder_name. '/');

        $check = $this->checkFolderName($path);

        if($check) {
            File::makeDirectory($path, 0755, true);
            return response()->json([ 'status' => 'success', 'msg' => 'Добавлено успешно.' ]);
        } else {
            return response()->json([ 'status' => 'error', 'msg' => 'Папка с таким именем уже есть в этой директории.' ]);
        }

    }

    public function updateMedia(Request $request)
    {
        $path = public_path($request->current_path . '/' . $request->new_name);

        switch ($request->rename_type){
            case 'folder':
                $path = $path. '/';
                $check = $this->checkFolderName($path);

                if($check) {
                    $p1 = public_path( $request->current_path . '/' . $request->old_name);
                    $p2 = $path;

                    if ( rename( $p1, $p2 ) ){

                        // TODO Когда в базе будут файлы надо при переименовании заменить все роуты

                        return response()->json([ 'status' => 'success', 'msg' => 'Изменено успешно.' ]);
                    } else {
                        return response()->json([ 'status' => 'error', 'msg' => 'Произошла ошибка при переименовании' ]);
                    }

                } else {
                    return response()->json([ 'status' => 'error', 'msg' => 'Папка с таким именем уже есть в этой директории.' ]);
                }

            case 'file':

                $check = $this->checkFileName($path);

                if($check) {
                    $p1 = public_path( $request->current_path . '/' . $request->old_name);
                    $p2 = $path;

                    if ( rename( $p1, $p2 ) ){

                        // TODO Когда в базе будут файлы надо при переименовании заменить все роуты

                        return response()->json([ 'status' => 'success', 'msg' => 'Изменено успешно.' ]);
                    } else {
                        return response()->json([ 'status' => 'error', 'msg' => 'Произошла ошибка при переименовании' ]);
                    }

                } else {
                    return response()->json([ 'status' => 'error', 'msg' => 'Файл с таким именем уже есть в этой директории.' ]);
                }
                break;
        }

    }

    public function uploadFiles(Request $request)
    {
        try {
            foreach ($request->files as $items) {
                foreach ($items as $file) {
                    $originalName = $file->getClientOriginalName();
                    $name = time() . "_" . $originalName;
                    $extension = $file->guessExtension();
//            Для сохранения в базу
//            $table->string('original_name', 255); $originalName
//            $table->string('path_name', 255); $name
//            $table->string('path', 500); $request->current_path + $name
//            $table->string('extension'); $extension
                    move_uploaded_file($file->getPathName(), $request->current_path . '/' . $name);
                }
            }
            return response()->json(['status' => 'success', 'msg' => 'Загружено успешно.']);
        } catch (\Exception $e){
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }

    public function delete(Request $request)
    {
        $path = public_path( $request->current_path . '/' . $request->to_remove);

        // TODO Удаление из базы

        if ( $request->remove_type === 'folder' ){
            if( File::deleteDirectory($path) ){
                return response()->json([ 'status' => 'success', 'msg' => 'Удалено успешно.' ]);
            }
        }
        if ( $request->remove_type === 'file' ){
           if( File::delete($path) ){
               return response()->json([ 'status' => 'success', 'msg' => 'Удалено успешно.' ]);
           }
        }

        return response()->json([ 'status' => 'error', 'msg' => 'Произошла ошибка при удалении' ]);
    }

    public function openFolder(Request $request)
    {
        $directories = File::directories(public_path($request->path_to_folder));
        $files = File::files(public_path($request->path_to_folder));

        $this->setFilesPath($files);

        return response()->json(['directories' => $directories, 'files' => $files, 'path_to_folder' => $request->path_to_folder]);
    }


    private function checkFolderName($path): Bool
    {
        if(File::isDirectory($path)) {
            // Такая папка уже есть
            return false;
        }
        return true;
    }
    private function checkFileName($path): Bool
    {
        if(File::exists($path)) {
            // Такой файл уже есть
            return false;
        }
        return true;
    }

    private function setFilesPath($files)
    {
        foreach ($files as $file){
            $path = explode('/', $file->getPathname() );
            foreach ($path as $key => $value){

                if($value !== 'public'){
                    unset($path[$key]);
                    continue;
                }

                unset($path[$key]);
                $file->pathFromPublic = '/' . implode('/', $path);
                $file->ext = $file->getExtension();
                break;
            }
        }
    }

}
