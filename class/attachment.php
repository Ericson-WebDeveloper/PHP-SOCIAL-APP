<?php


class Attachment
{

    public function checkDIR($folderName)
    {
        $path = realpath("public/attachments/$folderName");
        if (is_dir($path)) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function createDIR($folderName)
    {
        $response = mkdir(dirname(__DIR__, 1) . "/public/attachments/$folderName/", 0777, true);
        if (!$response) {
            return false;
        } else {
            return true;
        }
    }

    public function uploadAttachment($file, $folderName, $uuid)
    {
        try {
            $fileName = $file['attachment']['name'];
            $fileSize = $file['attachment']['size'];
            $fileTmpName  = $file['attachment']['tmp_name'];
            $fileType = $file['attachment']['type'];

            $uploadPath = dirname(__DIR__, 1) . "/public/attachments/$folderName/" . basename($fileName);
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

            if ($didUpload) {
                return $this->insertAttachmentDetail($uuid, $uploadPath, $fileName, $fileSize);
            } else {
                return false;
            }
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function insertAttachmentDetail($uuid, $uploadPath, $fileName, $fileSize)
    {
        try {
            $sql = "INSERT INTO `message_attachment_file`(`id`, `file_name`, `size`, `path`) VALUES ('$uuid','$fileName','$fileSize','$uploadPath')";
            $response = $this->connect->execute($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }
}

$file = new Attachment();
echo $file->createDIR('txt');
