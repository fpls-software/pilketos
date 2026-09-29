<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Public_election extends CI_Migration
{
	public function up()
	{
		$duplicate = $this->db->query(
			'SELECT username FROM tb_pilih GROUP BY username HAVING COUNT(*) > 1 LIMIT 1'
		)->row_array();
		if ($duplicate) {
			throw new RuntimeException(
				'Migration stopped: duplicate votes exist for voter '.$duplicate['username']
			);
		}
		$duplicate_number = $this->db->query(
			'SELECT no FROM tb_pilihan GROUP BY no HAVING COUNT(*) > 1 LIMIT 1'
		)->row_array();
		if ($duplicate_number) {
			throw new RuntimeException(
				'Migration stopped: candidate number '.$duplicate_number['no'].' is assigned more than once'
			);
		}

		$statements = array(
			'ALTER TABLE tb_admin
				MODIFY password VARCHAR(255) NOT NULL,
				ADD COLUMN wajib_ganti_password TINYINT(1) NOT NULL DEFAULT 0',
			'ALTER TABLE tb_siswa
				MODIFY password VARCHAR(255) NOT NULL,
				ADD COLUMN wajib_ganti_password TINYINT(1) NOT NULL DEFAULT 0',
			'ALTER TABLE tb_datapilketos
				ADD COLUMN deskripsi TEXT NULL,
				ADD COLUMN status VARCHAR(16) NOT NULL DEFAULT \'draft\',
				ADD COLUMN mulai DATETIME NULL,
				ADD COLUMN selesai DATETIME NULL,
				ADD COLUMN hasil_ditampilkan TINYINT(1) NOT NULL DEFAULT 0',
			'ALTER TABLE tb_pilihan
				MODIFY photo VARCHAR(255) NOT NULL,
				ADD COLUMN visi TEXT NULL,
				ADD COLUMN misi TEXT NULL,
				ADD UNIQUE KEY uq_tb_pilihan_no (no)',
			'ALTER TABLE tb_pilih ADD UNIQUE KEY uq_tb_pilih_username (username)',
			'DELETE FROM tb_admin
				WHERE username = \'admin\'
				AND password = \'21232f297a57a5a743894a0e4a801fc3\'',
			'UPDATE tb_admin SET wajib_ganti_password = 1
				WHERE CHAR_LENGTH(password) = 32
				AND password REGEXP \'^[0-9a-fA-F]+$\'',
			'UPDATE tb_siswa SET wajib_ganti_password = 1 WHERE password = username',
			'INSERT INTO tb_datapilketos (id, tapel, tgl)
				SELECT 1, \'\', \'2000-01-01\'
				WHERE NOT EXISTS (SELECT 1 FROM tb_datapilketos WHERE id = 1)'
		);

		foreach ($statements as $statement) {
			if ($this->db->query($statement) === FALSE) {
				return FALSE;
			}
		}

		return TRUE;
	}

	public function down()
	{
		return FALSE;
	}
}
