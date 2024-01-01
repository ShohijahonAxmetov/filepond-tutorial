<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class FilePondController extends Controller
{
    public function process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|array',
            'file.*' => 'required|file|max:5120'
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 500);
        }

        $file = $request->file('file.0');
        $tmpFolder = 'tmp';

        $fileName = $file->store($tmpFolder);

        if (!isset(session('files')[0])) {
            $sessionFiles[0] = $fileName;
        } else {
            $sessionFiles = session('files');
            $sessionFiles[] = $fileName;
        }
        session(['files' => $sessionFiles]);

        return $fileName;
    }

    public function revert(Request $request)
    {
        $file = $request->getContent();
        unlink(public_path('storage/'.$file));

        $sessionFiles = session('files');
        foreach ($sessionFiles as $key => $sessionFile) {
            if ($sessionFile == $file) unset($sessionFiles[$key]);
        }
        session(['files' => array_values($sessionFiles)]);

        return '';
    }

    public function load(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|max:255'
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 500);
        }

        $response = \Illuminate\Support\Facades\Response::make(File::get(public_path('storage/'.$request->input('file'))));
        $response->header('Content-Disposition', 'inline; filename="'.$request->input('file').'"');

        return $response;
    }

    public function remove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|max:255'
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 500);
        }

        $file = $request->input('file');

        unlink(public_path('storage/'.$file));

        $sessionFiles = session('files');
        foreach ($sessionFiles as $key => $sessionFile) {
            if ($sessionFile == $file) unset($sessionFiles[$key]);
        }
        session(['files' => array_values($sessionFiles)]);

        return '';
    }
}
