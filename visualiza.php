  <?php 
    include "conexion.inc.php";


?>
<html>


<link rel="stylesheet" href="css/style.css"/>
<div class="col-md-4">
    <center><h1 class="intro-text">VISUALIZA MEDIA DE NOTAS</h1>
    <p>Solo puede acceder si tienes el rol de Director....</p>   
<form method="POST" action="visualiza.php">
    <div class="form-group">
        <label for="ci">Carnet de Identidad</label>
        <input type="text" name="ci" value="" placeholder="Ingrese su carnet..">
        <input type="submit" name="verifica" value="VISUALIZAR POR DEP" >
    </div>

</form>
<?php if(isset($_POST['verifica'])){
        $ci = $_POST['ci'];
        $sql1 = mysqli_query($con,"SELECT * from acceso where ci ='".$ci."' and rol= 'director' ");
        
        $nr = mysqli_num_rows($sql1);
        if($nr >=1){
            echo "BIENVENIDO DIRECTOR(A): ";
            //header("Location: ../index.php");
            $sql2 =  "select p.nombrecompleto from acceso a inner join persona p on a.ci = p.ci where a.ci = '".$ci."'";
           $resultado = mysqli_query($con,$sql2);
           $fila = mysqli_fetch_array($resultado);
           echo $fila['nombrecompleto'];
           echo "<br>";
           echo "<br>";
           echo "<table border='1px'><tr>";
           echo "<td>CODIGO</td>";
           echo "<td>DEPARTAMENTO</td>";
           echo "<td>PROMEDIO NOTAS</td></tr>";
           
           $consulta = "SELECT p.departamento, p.d_dep, CAST(ROUND(AVG(notafinal),2) AS DEC(10,2)) promedio
           FROM persona p
           INNER JOIN inscripcion i ON i.ciestudiante = p.ci
           GROUP BY departamento
           ORDER BY departamento";
           $resul = mysqli_query($con,$consulta);
           while($fil = mysqli_fetch_array($resul)){
                echo "<tr>";
               echo "<td>".$fil['departamento']."</td>";
               echo "<td>".$fil['d_dep']."</td>";
               echo "<td>".$fil['promedio']."</td>";
               echo " </tr>";

           }
           


         }else if($nr==0){
            echo "NO ES DIRECTOR";
            header("Location: visualiza.php");
            }


    }
?>

</div>
<center><div><span>o <a href="index.php">Regresar</a></span></div></center>

</html>