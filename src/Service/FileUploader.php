<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $targetDirectory;
    private $em;
    private $slugger;

    public function __construct($targetDirectory, EntityManagerInterface $em, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->em = $em;
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
        try {
            $file->move(
                $this->getTargetDirectory(),
                $newFilename
            );
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $newFilename;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}
