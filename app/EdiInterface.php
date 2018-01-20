<?php

namespace App;

class EdiInterface extends UuidModel
{
    protected $fillable = [
        'agreement_uuid',
        'file_size',
        'file_name',
        'file_type',
        'file_at',
        'interface_partner',
        'interface_channel',
        'interface_version',
        'interface_source',
        'interface_destination',
        'interface_control_number',
        'interface_at',
        'queued_at',
        'processed_at'
    ];

    /**
     * Returns the S3 prefix to grab files from AWS S3
     */
    public function path()
    {
        return implode('/', [
            $this->interface_partner,
            $this->interface_channel,
            $this->file_type,
            $this->file_name
        ]);
    }

    public function agreements()
    {
        return $this->hasMany('App\Agreement', 'agreement_uuid', 'uuid');
    }
}
