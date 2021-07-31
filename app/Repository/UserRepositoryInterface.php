<?php
namespace App\Repository;

interface UserRepositoryInterface
{
   public function all();
   public function show($userId);
   public function Create($userDetails);
   public function Update($userId,$userDetails);
   public function Delete($userId);
}