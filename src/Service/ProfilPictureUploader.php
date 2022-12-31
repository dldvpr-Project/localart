<?php

namespace App\Service;

use App\Entity\Artist;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfilPictureUploader
{
    private string $targetDirectory;
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->targetDirectory = $_ENV['PROFILPICTURE_FOLDER'];
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        $file->move($this->getTargetDirectory(), $fileName);


        return $fileName;
    }

    public function edit(UploadedFile $file, string $oldFile): string
    {

        unlink($_SERVER['DOCUMENT_ROOT'] . $oldFile);

        return $this->upload($file);
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}