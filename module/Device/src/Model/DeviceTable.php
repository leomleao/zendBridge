<?php

namespace Device\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class DeviceTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getDevice($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveDevice(Device $device)
    {
        $data = [
            'artist' => $Device->artist,
            'title'  => $Device->title,
        ];

        $id = (int) $Device->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getDevice($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update device with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteDevice($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}