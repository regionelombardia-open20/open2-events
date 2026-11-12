<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\models
 * @author    Aria S.p.A. <protocollo@pec.ariaspa.it>
 * @license   GNU General Public License v3.0 <https://www.gnu.org/licenses/gpl-3.0.html>
 * @link      https://www.ariaspa.it/
 *
 * This file is part of OPEN 2.0.
 *
 * OPEN 2.0 is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OPEN 2.0 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OPEN 2.0. If not, see <https://www.gnu.org/licenses/>.
 */

namespace open20\amos\events\models;

use open20\amos\events\AmosEvents;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class EventInvitationsUpload
 * @package open20\amos\events\models
 */
class EventInvitationsUpload extends Model
{
    public $excelFile;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['excelFile'], 'file', 'extensions' => 'xls, xlsx', 'checkExtensionByMimeType' => false],
        ];
    }

    /**
     * @return array|bool|string
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function parse()
    {
        $this->excelFile = UploadedFile::getInstance($this, 'excelFile');
        if ($this->validate()) {
            try {
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($this->excelFile->tempName);
                $worksheet = $spreadsheet->getActiveSheet();
                $highestRow = $worksheet->getHighestDataRow();
                // $highestColumn = $worksheet->getHighestColumn();
                // $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
                $rows = [];
                for ($r = 2; $r <= $highestRow; ++$r) { // Skip first row
                    $rows[] = [
                        'email' => $worksheet->getCellByColumnAndRow(3, $r)->getValue(),
                        'fiscal_code' => $worksheet->getCellByColumnAndRow(4, $r)->getValue(),
                        'name' => $worksheet->getCellByColumnAndRow(1, $r)->getValue(),
                        'surname' => $worksheet->getCellByColumnAndRow(2, $r)->getValue(),
                    ];
                }
                return $rows;
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                return $e->getMessage();
            }
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'excelFile' => AmosEvents::txt('#invitations_excel_file'),
        ];
    }
}
