<?php
    class UploadGateway
    {
        private PDO $conn;
        
        public function __construct( Database $database )
        {
            $this -> conn = $database -> getConnection();
        }
        
        public function getAll(): array
        {
            $sql = "SELECT *
                    FROM files";
                    
            $stmt = $this -> conn -> query( $sql );

            $data = [];
            
            while ( $row = $stmt -> fetch( PDO::FETCH_ASSOC )) {

                // Convert boolean from number to boolean type
                // $row["is_available"] = (bool) $row["is_available"];

                $data[] = $row;
            }
            
            return $data;
        }
        
        public function create( array $data ): string
        {
            // Set Local TimeZone
            date_default_timezone_set( "Asia/Kuala_Lumpur" );

            // Convert File Data into String
            $fileData = file_get_contents( $data[ 'tmp_name' ]);

            // Random Generate String
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen( $characters );
            $randomString = '';
            for ( $i = 0; $i < 3; $i++ ) {
                $randomString .= $characters[ random_int( 0, $charactersLength - 1 )];
            }

            // Create New Name Based on Current Time
            $newName = idate( 'Y' ) . idate( 'm' ) . idate( 'd' ) . idate( 'H' ) . idate( 'i' ) . idate( 's' ) . '-' . $randomString;

            // Save File into Folder
            $path_parts = pathinfo( $data[ "name" ]);
            $extension = $path_parts[ 'extension' ];
            $file_path = '/files/' . $newName . '.' . $extension;
            file_put_contents( '.' . $file_path, $fileData );

            // Insert Data Into Database
            $sql = "INSERT INTO files (filename, type, size, path)
                    VALUES (:filename, :type, :size, :path)";
                    
            $stmt = $this -> conn -> prepare( $sql );
            
            $stmt -> bindValue( ":filename", $newName, PDO::PARAM_STR );
            $stmt -> bindValue( ":type", $data[ "type" ], PDO::PARAM_STR );
            $stmt -> bindValue( ":size", $data[ "size" ] ?? 0, PDO::PARAM_INT );
            $stmt -> bindValue( ":path", $file_path, PDO::PARAM_STR );
            
            $stmt -> execute();
            
            return $this -> conn -> lastInsertId();
        }
        
        public function get(string $id): array | false
        {
            // $sql = "SELECT *
            //         FROM product
            //         WHERE id = :id";
                    
            // $stmt = $this->conn->prepare($sql);
            
            // $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            
            // $stmt->execute();
            
            // $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // if ($data !== false) {
            //     $data["is_available"] = (bool) $data["is_available"];
            // }
            
            // return $data;
        }
        
        public function update(array $current, array $new): int
        {
            // $sql = "UPDATE product
            //         SET name = :name, size = :size, is_available = :is_available
            //         WHERE id = :id";
                    
            // $stmt = $this->conn->prepare($sql);
            
            // $stmt->bindValue(":name", $new["name"] ?? $current["name"], PDO::PARAM_STR);
            // $stmt->bindValue(":size", $new["size"] ?? $current["size"], PDO::PARAM_INT);
            // $stmt->bindValue(":is_available", $new["is_available"] ?? $current["is_available"], PDO::PARAM_BOOL);
            
            // $stmt->bindValue(":id", $current["id"], PDO::PARAM_INT);
            
            // $stmt->execute();
            
            // return $stmt->rowCount();
        }
        
        public function delete(string $id): int
        {
            // $sql = "DELETE FROM product
            //         WHERE id = :id";
                    
            // $stmt = $this->conn->prepare($sql);
            
            // $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            
            // $stmt->execute();
            
            // return $stmt->rowCount();
        }
    }
?>