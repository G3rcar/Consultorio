<?
class Roles
{
    protected $permisos;
 
    protected function __construct() {
        $this->permisos = array();
    }
 
    // Devuelve el objeto  rol con los permisos correspondientes
    public static function getRolPerms($id_Rol) {
        $Rol = new Rol();
        $sql = "SELECT t2.perm_desc FROM Rol_perm as t1
                JOIN permisos as t2 ON t1.id_perm = t2.id_perm
                WHERE t1.id_Rol = :id_Rol";
        $sth = $GLOBALS["DB"]->prepare($sql);
        $sth->execute(array(":id_Rol" => $id_Rol));
 
        while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $Rol->permisos[$row["perm_desc"]] = true;
        }
        return $Rol;
    }
 
    // Comprueba si se ha establecido un permiso
    public function hasPerm($permisos) {
        return isset($this->permisos[$permisos]);
    }
}
?>
