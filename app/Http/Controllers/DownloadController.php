<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadController extends Controller
{
    public function downloadFile($filename)
    {
        $filePath = storage_path('app/' . $filename); // ファイルが保存されているパス

        if (!file_exists($filePath)) {
            return abort(404, 'File not found.');
        }

        return response()->download($filePath);
            
        /*
        $filePath = 'public/tkport_manual.xlsx';
        $fileName = 'tkport_manual.xlsx';
        
        $mimeType = Storage::mimeType($filePath);
        $headers = [['Content-Type' => $mimeType]];
        
        return Storage::download($filePath, $fileName, $headers);
        */
    }
}
