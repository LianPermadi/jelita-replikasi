<?php

use Cviebrock\EloquentSluggable\Sluggable; // Added this line
require_once __DIR__ . '/../../vendor/cviebrock/eloquent-sluggable/src/Sluggable.php'; // Updated path to load the file correctly

use Illuminate\Database\Eloquent\Builder;
class Homepage extends CI_Model {
    protected $primaryKey = 'Id';
    protected $table = 'homepage';

    protected $fillable = [
        'isBahasa', // Added the property isBahasa to the fillable array
        // other fillable properties...
    ];

    // Define a getter method for the isBahasa property
    public function getIsBahasaAttribute()
    {
        return $this->attributes['isBahasa'];
    }

    // Define sluggable method manually
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function get_by($isBahasa = NULL)
    {
        if (!is_null($isBahasa)) {
            $sql = "SELECT * FROM homepage WHERE isBahasa = ?";
            $query = $this->db->query($sql, array($isBahasa));
        } else {
            $sql = "SELECT * FROM homepage";
            $query = $this->db->query($sql);
        }
    
        // Debug SQL sebenarnya yang dijalankan 
        // echo $this->db->last_query(); die;
        $executed_sql = $this->db->last_query();
        // Simpan ke log atau tampilkan di UI dev-only
        // log_message('debug', 'SQL executed: ' . $executed_sql);die();
    
        return $query->result();
    }
    
    public function get_by_v2($isBahasa = NULL)
    {
        // var_dump($isBahasa);
        if ($isBahasa == NULL) {
            $sql = "SELECT id, nama, value_id as value, status FROM homepage_v2";
            $query = $this->db->query($sql, array($isBahasa));
        } elseif($isBahasa == 1) {
            $sql = "SELECT id, nama, value_en as value, status FROM homepage_v2";
            $query = $this->db->query($sql);
        } elseif($isBahasa == 0) {
            $sql = "SELECT id, nama, value_id as value, status FROM homepage_v2";
            $query = $this->db->query($sql);
        } else {
            $sql = "SELECT id, nama, value_en as value, status FROM homepage_v2";
            $query = $this->db->query($sql);
        }
        // var_dump($query->result());die();
    
        // Debug SQL sebenarnya yang dijalankan 
        // echo $this->db->last_query(); die;
        $executed_sql = $this->db->last_query();
        // Simpan ke log atau tampilkan di UI dev-only
        // log_message('debug', 'SQL executed: ' . $executed_sql);die();
    
        return $query->result();
    }
}

?>

