<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class LifeandmeResourceJson extends JsonResource
{

    protected string $messageShow = 'process successfully done';
    /**
     * Get additional data that should be returned with the resource array.
     * @param Request $request
     * @return array
     */
    public function with( $request ): array
    {
        return [
            "status" => true,
            'message' => $this->messageShow
        ];
    }

    public static function collection( $resource )
    {
        return tap( new AnonymousResourceCollection( $resource, static::class ), function ( $collection ) {
            if ( property_exists( static::class, 'preserveKeys' ) ) {
                $collection->preserveKeys = ( new static( [] ) )->preserveKeys === true;
            }
        } );
    }

/*    protected function removeMissingValues( $data )
    {
        $numericKeys = true;

        foreach ( $data as $key => $value ) {
            if ( ( $value instanceof PotentiallyMissing && $value->isMissing() ) ||
                ( $value instanceof self &&
                    $value->resource instanceof PotentiallyMissing &&
                    $value->isMissing() ) ) {
                unset( $data[ $key ] );
            } else {
                $numericKeys = $numericKeys && is_numeric( $key );
            }


             //By adding this peace of code, Mohammad will stop nagging about null values.

            if ( is_null( $value ) ) {

                $table = method_exists( $this->resource, 'getTable' )
                    ? $this->resource->getTable()
                    : $this->resource[ 0 ]->resource->getTable();

                $type = '';

                $fields = DB::select( DB::raw( "SHOW COLUMNS FROM `$table`" ) );
                foreach ( $fields as $field ) {
                    if ( $field->Field == $key )
                        $type = $field->Type;
                }

                //                $isString = strstr($type, 'varchar') || strstr($type, 'text') || strstr($type, 'enum');
                $isNumber = strstr( $type, 'int' ) || strstr( $type, 'double' ) || strstr( $type, 'float' );

                if ( $isNumber )
                    $data[ $key ] = 0;
                else
                    $data[ $key ] = '';

            }

        }

        if ( property_exists( $this, 'preserveKeys' ) && $this->preserveKeys === true ) {
            return $data;
        }

        return $numericKeys ? array_values( $data ) : $data;
    }*/

}
