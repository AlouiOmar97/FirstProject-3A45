<?php

namespace App\Service;

use App\Repository\AuthorRepository;

class AuthorService
{
    public function getModifiedAuthors(int $limit, AuthorRepository $authorRepository): array
    {
        // Use the passed repository to fetch authors
        $authors = $authorRepository->findBy([], null, $limit);
        
        // Modify authors data (for example, doubling the number of books)
        foreach ($authors as $author) {
            $author->setNbBooks($author->getNbBooks() * 10);
        }

        return $authors;
    }
}
