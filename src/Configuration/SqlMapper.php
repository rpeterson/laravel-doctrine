<?php namespace Mitch\LaravelDoctrine\Configuration;

class SqlMapper implements Mapper
{
	/**
	 * Creates the configuration mapping for SQL database engines, including SQL server, MySQL and PostgreSQL.
	 *
	 * @param array $configuration
	 * @return array
	 */
	public function map(array $configuration)
	{
		$config = [
			'host' => $configuration['host'],
			'dbname' => $configuration['database'],
			'user' => $configuration['username'],
			'password' => $configuration['password'],
			'charset' => $configuration['charset']
		];

		if (isset($configuration['driver'])) {
			$config['driver'] = $this->driver($configuration['driver']);
		}

		if (isset($configuration['driver_class'])) {
			$config['driverClass'] = $configuration['driver_class'];
		}

		return $config;
	}

	/**
	 * Is suitable for mapping configurations that use a mysql, postgres or sqlserv setup.
	 *
	 * @param array $configuration
	 * @return boolean
	 */
	public function isAppropriateFor(array $configuration)
	{
		if (!isset($configuration['driver']) && $configuration['driver_class']) {
			return in_array($configuration['driver_class'], ['FDB\SQL\DBAL\PDOFoundationDBSQLDriver']);
		}
		return in_array($configuration['driver'], ['sqlsrv', 'mysql', 'pgsql', 'fdbsql']);
	}

	/**
	 * Maps the Laravel driver syntax to an Sql doctrine format.
	 *
	 * @param $l4Driver
	 * @return string
	 */
	public function driver($l4Driver)
	{
		$doctrineDrivers = ['mysql' => 'pdo_mysql', 'sqlsrv' => 'pdo_sqlsrv', 'pgsql' => 'pdo_pgsql'];

		return $doctrineDrivers[$l4Driver];
	}
}
