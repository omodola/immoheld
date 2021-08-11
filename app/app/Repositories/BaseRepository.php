<?php
namespace App\Repositories;

use CodeIgniter\Database\BaseConnection;
use Config\Database;
use Exception;
use Exceptions\DatabaseException;
use stdClass;

class BaseRepository
{
    protected BaseConnection $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * @param string $table
     * @param array $data
     * @return int
     * @throws DatabaseException
     */
    protected function insert(string $table, array $data): int
    {
        try {
            $this->db->table($table)->insert($data);
            return (int)$this->db->insertID();
        }catch (Exception $exception){
            throw new DatabaseException($exception->getMessage());
        }
    }

    /**
     * @param string $sql
     * @param array $args
     * @return stdClass|null
     * @throws DatabaseException
     */
    protected function fetchOne(string $sql, array $args=[]): ?stdClass
    {
        try{
            $data = $this->db->query($sql,[$args])->getResultObject();
            return $data[0] ?? null;
        }catch (Exception $exception){
            throw new DatabaseException($exception->getMessage());
        }
    }

    /**
     * @param string $sql
     * @param array $args
     * @return array
     * @throws DatabaseException
     */
    protected function fetchData(string $sql, array $args=[]): array
    {
        try{
            return $this->db->query($sql,[$args])->getResultObject();
        }catch (Exception $exception){
            throw new DatabaseException($exception->getMessage());
        }
    }

    /**
     * @param string $table
     * @param array $condition
     * @param array $args
     */
    protected function update(string $table, array $condition, array $args): void
    {
        $this->db
            ->table($table)
            ->where($condition)
            ->update($args);
    }

    /**
     * @param array $condition
     * @return string
     */
    protected function buildWhere(array $condition): string
    {
        $where = ' ';
        foreach ($condition as $key => $value) {
            if (is_null($value)) {
                $where .= sprintf(" %s AND ",$key);
            } else {
                $where .= sprintf(" %s = '%s' AND ",$key, $value);
            }
        }
        $where =  rtrim($where, ' AND ');

        if(!empty($where)){
            $where = ' WHERE '.$where;
        }

        return $where;
    }

    /**
     * @param string $orderBy
     * @param string $order
     * @return string
     */
    protected function setOrderBY( ?string $orderBy='id',?string $order='asc'): string
    {
        return sprintf(" ORDER BY %s %s ",$orderBy, $order);
    }

    /**
     * @param string $limit
     * @return string
     */
    protected function setLimit(string $limit): string
    {
        return sprintf(" LIMIT %s ", $limit);
    }
}