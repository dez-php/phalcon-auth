<?php

    namespace PhalconDez\Auth\Util;

    /**
     * Class UUID
     * @package Dez\Auth\Hasher
     */

    class UUID {

        /**
         * @return string
         */
        static public function v4()
        {
            return sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
                mt_rand( 0, 0xffff ),
                0x4000 | mt_rand( 0, 0x0fff ),
                0x8000 | mt_rand( 0, 0x3fff ),
                mt_rand( 0, 0x0fff ), mt_rand( 0, 0x0fff ), mt_rand( 0, 0x0fff )
            );
        }

        /**
         * @param string $data
         * @return string
         */
        static public function v5( $data = '' )
        {

            $namespace  = str_replace( '-', '', '6ba7b814-9dad-11d1-80b4-00c04fd430c8' );

            $nsString   = '';

            for( $i = 0, $c = strlen( $namespace ); $i < $c; $i++ ) {
                $nsString   .= chr( hexdec( $namespace[ $i ] . ( $i == 31 ? '' : $namespace[ $i + 1 ] ) ) );
            }

            $sha1   = sha1( $nsString . $data );

            return sprintf(
                '%08s-%04s-%04x-%04x-%12s',
                substr( $sha1, 0, 8 ),
                substr( $sha1, 8, 4 ),
                0x5000 | ( hexdec( substr( $sha1, 12, 4 ) ) & 0x0fff ),
                0x8000 | ( hexdec( substr( $sha1, 16, 4 ) ) & 0x3fff ),
                substr( $sha1, 20, 12 )
            );

        }

    }