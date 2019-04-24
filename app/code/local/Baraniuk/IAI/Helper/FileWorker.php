<?php

    class Baraniuk_IAI_Helper_FileWorker {

        /**
         * @param $path
         *
         * @return array (name, type)
         */
        public function getNameType($path) {

            $expoldePath = explode('.', $path);

            $type = '.' . $expoldePath[count($expoldePath)-1];

            $fileNameLen = strlen($path) - strlen($type);

            $fileName = substr($path, 0, $fileNameLen) ;

            return array('name' => $fileName, 'type' => $type);
        }

        /**
         * @param $path
         *
         * @return string
         */
        public function generateName ($path) : string {

            $i = 1;

            do {
                $isOk = file_exists($path);

                if ($isOk) {

                    $name_type = $this->getNameType($path);

                    if ($i > 1) {

                        $getIterator = explode('_', $name_type[ 'name' ]);
                        unset($getIterator[count($getIterator) - 1]);
                        $getIterator = implode('_', $getIterator);
                        $name_type[ 'name' ] = substr($name_type[ 'name' ],0, strlen($getIterator));
                    }

                    $path = $name_type[ 'name' ] . '_' . $i . $name_type[ 'type' ];

                    $i++;
                }
            } while ($isOk);

            return $path;
        }

        /**
         * @param $path
         *
         * @return bool
         */
        public function deleteFile ($path) : bool {
            if (unlink($path)) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * @param string $path
         * @param string $content
         *
         * @return bool|string
         */
        public function createFile (string $path, string $content) {

            if (file_put_contents( $path , $content )) {
                return $path;
            } else {
                return false;
            }
        }

    }