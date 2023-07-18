<?php 
namespace App\Models;
use CodeIgniter\Model;

class ProductModel extends Model{

	protected $DBGroup = 'default';
	protected $table = 'product';
	protected $primaryKey = 'id';
	protected $returnType = 'array';
	protected $allowedFields = ['name','code','price','quantity','gst','file','manufacturer_id','created','updated','status'];
	protected $createdField = 'created';
}
