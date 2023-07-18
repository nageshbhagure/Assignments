<?php 
namespace App\Models;
use CodeIgniter\Model;

class StockModel extends Model{

	protected $DBGroup = 'default';
	protected $table = 'stock';
	protected $primaryKey = 'id';
	protected $returnType = 'array';
	protected $allowedFields = ['product_id','product_code','quantity','created','updated','status','manufacturer_id'];
	protected $createdField = 'created';
}
