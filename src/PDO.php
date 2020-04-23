<?php
namespace Filisko\PDOplus;

class PDO extends \Aura\Sql\ExtendedPdo
{
    /**
     * Logged queries.
     * @var array
     */
    protected $log = [];

    /**
     * Relay all calls.
     *
     * @param string $name      The method name to call.
     * @param array  $arguments The arguments for the call.
     *
     * @return mixed The call results.
     */
    public function __call($name, array $arguments)
    {
        return call_user_func_array(
            array($this, $name),
            $arguments
        );
    }

    /**
     * @see \PDO::prepare
     */
    public function prepare($statement, $driver_options = [])
    {
        $PDOStatement = parent::prepare($statement, $driver_options);
        $new = new \Filisko\PDOplus\PDOStatement($this, $PDOStatement);
        return $new;
    }

    /**
     * @see \PDO::exec
     */
    public function exec($statement)
    {
        $start = microtime(true);
        $result = parent::exec($statement);
        $this->addLog($statement, microtime(true) - $start);
        return $result;
    }

    /**
     * @see \PDO::query
     */
    public function query($statement, ...$fetch)
    {
        $start = microtime(true);
        $result = parent::query($statement);
        $this->addLog($statement, microtime(true) - $start);
        return $result;
    }

	/**
     * @see \Aura\Sql\ExtendedPdo::fetchAffected
     */
    public function fetchAffected($statement, array $values = [])
    {
        $start = microtime(true);
        $result = parent::fetchAffected($statement, $values);
        $this->addLog($statement, microtime(true) - $start);
        return $result;
    }

	/**
     * @see \Aura\Sql\ExtendedPdo::fetchAll
     */ 
	public function fetchAll($statement, array $values = [])
    {
        $start = microtime(true);
        $result = parent::fetchAll($statement, $values);
        $this->addLog($statement, microtime(true) - $start);
        return $result;
    }

	/**
     * @see \Aura\Sql\ExtendedPdo::fetchAssoc
     */
	public function fetchAssoc($statement, array $values = [])
    {
        $start = microtime(true);
        $result = parent::fetchAssoc($statement, $values);
        $this->addLog($statement, microtime(true) - $start);
        return $result;
    }

	/**
     * @see \Aura\Sql\ExtendedPdo::fetchCol
     */
	public function fetchCol($statement, array $values = [])
    {
        $start = microtime(true);
        $result = parent::fetchCol($statement, $values);
        $this->addLog($statement, microtime(true) - $start);
        return $result;
    }
	
	/**
     * @see \Aura\Sql\ExtendedPdo::fetchGroup
     */
	public function fetchGroup($statement, array $values = [], $style = PDO::FETCH_COLUMN )
    {
        $start = microtime(true);
        $result = parent::fetchGroup($statement, $values, $style);
        $this->addLog($statement, microtime(true) - $start);
        return $result;
    }
	
	/**
     * @see \Aura\Sql\ExtendedPdo::fetchOne
     */
	public function fetchOne($statement, array $values = [])
    {
        $start = microtime(true);
        $result = parent::fetchOne($statement, $values);
        $this->addLog($statement, microtime(true) - $start);
        return $result;
    }	

	/**
     * @see \Aura\Sql\ExtendedPdo::fetchPairs
     */
	  public function fetchPairs($statement, array $values = [])
    {
        $start = microtime(true);
        $result = parent::fetchPairs($statement, $values);
        $this->addLog($statement, microtime(true) - $start);
        return $result;
    }

    /**
     * @see \Aura\Sql\ExtendedPdo::fetchValue
     */
    public function fetchValue($statement, array $values = [])
    {
        $start = microtime(true);
        $result = parent::fetchValue($statement, $values);
        $this->addLog($statement, microtime(true) - $start);
        return $result;
    }
	
    /**
     * Add query to logged queries.
     * @param string $statement
     * @param float $time Elapsed seconds with microseconds
     */
    public function addLog($statement, $time)
    {
        $query = [
            'statement' => $statement,
            'time' => $time * 1000
        ];
        array_push($this->log, $query);
    }

    /**
     * Return logged queries.
     * @return array Logged queries
     */
    public function getLog()
    {
        return $this->log;
    }
}
