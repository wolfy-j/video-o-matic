<?php
class OrmDefault08438940015588656551D1bccd313eb5c62bf84c901f9f60e2d6 extends Spiral\Migrations\Migration
{
    const DATABASE = 'default';

    public function up()
    {
        $this->table('videos')
            ->addColumn('id', 'primary', [
                'nullable' => false,
                'default'  => null
            ])
            ->addColumn('created_at', 'datetime', [
                'nullable' => false,
                'default'  => null
            ])
            ->addColumn('filename', 'text', [
                'nullable' => false,
                'default'  => null
            ])
            ->addColumn('size', 'integer', [
                'nullable' => false,
                'default'  => null
            ])
            ->addColumn('title', 'text', [
                'nullable' => false,
                'default'  => null
            ])
            ->addColumn('duration', 'float', [
                'nullable' => false,
                'default'  => null
            ])
            ->addIndex(["filename"], [
                'name'   => 'videos_index_filename_5cea66f7c78bf',
                'unique' => true
            ])
            ->setPrimaryKeys(["id"])
            ->create();
        
        $this->table('streams')
            ->addColumn('id', 'primary', [
                'nullable' => false,
                'default'  => null
            ])
            ->addColumn('index', 'integer', [
                'nullable' => false,
                'default'  => null
            ])
            ->addColumn('type', 'enum', [
                'nullable' => false,
                'default'  => null,
                'values'   => [
                    'video',
                    'audio',
                    'subtitle'
                ]
            ])
            ->addColumn('title', 'text', [
                'nullable' => true,
                'default'  => null
            ])
            ->addColumn('codec_name', 'text', [
                'nullable' => true,
                'default'  => null
            ])
            ->addColumn('language', 'text', [
                'nullable' => true,
                'default'  => null
            ])
            ->addColumn('video_id', 'integer', [
                'nullable' => false,
                'default'  => null
            ])
            ->addIndex(["video_id"], [
                'name'   => 'streams_index_video_id_5cea66f7c773e',
                'unique' => false
            ])
            ->addForeignKey('video_id', 'videos', 'id', [
                'name'   => 'streams_video_id_fk',
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ])
            ->setPrimaryKeys(["id"])
            ->create();
        
        $this->table('plays')
            ->addColumn('id', 'primary', [
                'nullable' => false,
                'default'  => null
            ])
            ->addColumn('created_at', 'datetime', [
                'nullable' => false,
                'default'  => null
            ])
            ->addColumn('ready', 'integer', [
                'nullable' => false,
                'default'  => null
            ])
            ->addColumn('video_id', 'integer', [
                'nullable' => true,
                'default'  => null
            ])
            ->addColumn('audio_id', 'integer', [
                'nullable' => true,
                'default'  => null
            ])
            ->addIndex(["video_id"], [
                'name'   => 'plays_index_video_id_5cea66f7c6fd8',
                'unique' => false
            ])
            ->addIndex(["audio_id"], [
                'name'   => 'plays_index_audio_id_5cea66f7c770a',
                'unique' => false
            ])
            ->addForeignKey('video_id', 'videos', 'id', [
                'name'   => 'plays_video_id_fk',
                'delete' => 'SET NULL',
                'update' => 'SET NULL'
            ])
            ->addForeignKey('audio_id', 'streams', 'id', [
                'name'   => 'plays_audio_id_fk',
                'delete' => 'SET NULL',
                'update' => 'SET NULL'
            ])
            ->setPrimaryKeys(["id"])
            ->create();
        
        $this->table('thumbnails')
            ->addColumn('id', 'primary', [
                'nullable' => false,
                'default'  => null
            ])
            ->addColumn('video_id', 'integer', [
                'nullable' => false,
                'default'  => null
            ])
            ->addIndex(["video_id"], [
                'name'   => 'thumbnails_index_video_id_5cea66f7c776d',
                'unique' => false
            ])
            ->addForeignKey('video_id', 'videos', 'id', [
                'name'   => 'thumbnails_video_id_fk',
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ])
            ->setPrimaryKeys(["id"])
            ->create();
    }

    public function down()
    {
        $this->table('thumbnails')->drop();
        
        $this->table('plays')->drop();
        
        $this->table('streams')->drop();
        
        $this->table('videos')->drop();
    }
}