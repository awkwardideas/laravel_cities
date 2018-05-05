<?php namespace AwkwardIdeas\LaravelCities\commands\helpers;

class DB{
    private $connection = [
        "host"=>"",
        "database"=>"",
        "username"=>"",
        "password"=>""
    ];
    private $process=false;
    private $db;

    public function __construct()
    {
        self::GetConnectionData();
        $this->db = new DB();
    }

    private function GetConnectionData(){
        $filePath = getcwd().'/.env';
        if (file_exists($filePath)) {
            $handle = @fopen($filePath, "r");
            if ($handle) {
                while (($buffer = fgets($handle, 4096)) !== false) {
                    $value = self::GetEnvVariable("DB_HOST", $buffer);
                    if ($value !== false){
                        $this->connection["host"] = $value;
                        continue;
                    }
                    $value = self::GetEnvVariable("DB_DATABASE", $buffer);
                    if ($value !== false){
                        $this->connection["database"] = $value;
                        continue;
                    }
                    $value = self::GetEnvVariable("DB_USERNAME", $buffer);
                    if ($value !== false){
                        $this->connection["username"] = $value;
                        continue;
                    }
                    $value = self::GetEnvVariable("DB_PASSWORD", $buffer);
                    if ($value !== false){
                        $this->connection["password"] = $value;
                        continue;
                    }
                }
                if (!feof($handle)) {
                    echo "Error: unexpected fgets() fail\n";
                }
                fclose($handle);
            }
        }

        if($this->connection["host"]!="" && $this->connection["database"]!="" && $this->connection["username"]!="" && $this->connection["password"]!="") $this->process=true;
    }

    private function GetEnvVariable($variableName, $buffer){
        if (strpos(strtoupper($buffer), $variableName."=") > -1) {
            $removeFromFileValue = "/[\n\r]/";
            return preg_replace($removeFromFileValue, '', after("=", $buffer));
        }else{
            return false;
        }
    }

    private function EstablishConnection(){
        if(!$this->process)
            return "<p>Required connection data not found in .env</p>";

        if($this->db->EstablishConnections($this->GetHost(), $this->GetDatabase(), $this->GetUsername(), $this->GetPassword(), $this->GetUsername(), $this->GetPassword()))
            return "<p>Connected to <b>".$this->GetDatabase()."</b> on <b>".$this->GetHost()."</b>.</p>";
        else
            return "<p>Unable to connect. Please verify permissions.</p>";
    }

    private function CloseConnection(){
        $this->db->CloseConnections();
        $this->process = false;
    }

    public function GetHost(){
        return $this->connection["host"];
    }

    public function GetDatabase(){
        return $this->connection["database"];
    }

    public function SetDatabase($database){
        $this->CloseConnection();
        $this->connection["database"] =$database;
        $this->process = true;
        $this->EstablishConnection();
    }

    public function GetUsername(){
        return $this->connection["username"];
    }

    public function GetPassword(){
        return $this->connection["password"];
    }
}