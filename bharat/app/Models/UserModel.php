<?php 
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model{

	protected $DBGroup = 'default';
	protected $table = 'users';
	protected $primaryKey = 'id';
	protected $returnType = 'array';
	protected $allowedFields = ['username','password','role','created','updated','status'];
	protected $createdField = 'created';
}
