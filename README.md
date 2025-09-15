AYUDAME A ANALIZAR ESTE MODELO RELACIONAL , QUE TODO CORRECTO . LUEGO DE VERIFICICAR Y ANALIZAR MUY BIEN 1. QUIERO QUE ME DES CADA UNA DE  LAS MIRACIONES COMPLETAS EN INGLES PARA BUENAS PRACTICAS ( TODO EL CODIGO , NO FRAGMNETOS Y TAMBIEN DEJALO ASI SIN CLAVES PERSONALIZADAS :  $table->id(); ) , 2. LUEGO DE ESTO ME DAS CADA UNO DE LOS MODELOS NECESARIOS CON FILLLABLE , SCOPES Y SU RESPECTIVAS RELACIONES 3. LUEGO DEL ANTERIOR PASO , ME DAS CADA UNOS DE LOS CONTROLADORES NECESARIOS  CON PAGINATE  , FILTER , ASC , DESC Y TODO EL CRUD SI ES NECESARIO 4.LUEGO DEL ANTERIOR PASO ME DAS CADA UNO DE LOS FACTORIES PARA CADA MODELO Y TAMBIEN CADA SEEDERS INCLUIDO   DBseeder .  5. POR ULTIMO PASO ME DAS TODAS LAS RUTAS DEL ARCHIVO api.php , MEDAS CADA UNA DE LA RUTAS NECESARIAS Y TAMBIEN LAS POSIBLES CONSULTAS QUE SE PUEDEN HACER CON Postman . ( VAMOS PASO POR PASO , PRIMERO TERMINAS EL PASO 1 Y LUEGO VAMOS POR EL OTRO , ME DEBES DE CONSULTAR SI QUIERO EL SIGUIENTE ) Y RECUERDA QUE PARA MEJORES PRACTICAS LAS TABLAS VAN EN INGLES .




# Obtener todos los recursos (paginados)
GET /api/resource?page=1&per_page=10

# Filtrar por campo
GET /api/resource?field=value

# Búsqueda por texto (si la API lo soporta)
GET /api/resource?search=palabra

# Ordenar resultados
GET /api/resource?sort_field=nombre&sort_order=asc

# Obtener un recurso por ID
GET /api/resource/{id}



5. Tipos de Relaciones en Laravel

belongsTo → Un hijo pertenece a un padre (ej: un jugador pertenece a un equipo).

hasOne → Un padre tiene un hijo (ej: un presidente tiene un equipo).

hasMany → Un padre tiene muchos hijos (ej: un equipo tiene muchos jugadores).

belongsToMany → Relación muchos a muchos (ej: jugadores y partidos).
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
🔹 hasOne
Tipo de relación: Uno a Uno (1:1)

Descripción: Un registro de un modelo está relacionado con un solo registro de otro modelo.

Ejemplo real: Un usuario tiene un único perfil (User - Profile).

Dónde se usa: En el modelo "dueño" de la relación (el que contiene el otro).

🔹 hasMany
Tipo de relación: Uno a Muchos (1:N)

Descripción: Un registro de un modelo puede tener muchos registros relacionados en otro modelo.

Ejemplo real: Un blog tiene muchos comentarios (Post - Comments).

Dónde se usa: En el modelo que posee los múltiples elementos.

🔹 belongsTo
Tipo de relación: Muchos a Uno (N:1)

Descripción: Un registro pertenece a un solo registro de otro modelo.

Ejemplo real: Un comentario pertenece a un post (Comment - Post).

Dónde se usa: En el modelo que depende del otro, generalmente el que contiene la clave foránea.

🔹 belongsToMany
Tipo de relación: Muchos a Muchos (N:M)

Descripción: Un registro puede estar relacionado con muchos otros registros, y viceversa.

Ejemplo real: Un estudiante puede inscribirse en muchos cursos, y un curso puede tener muchos estudiantes.

Dónde se usa: En ambos modelos que participan de la relación, con una tabla intermedia (pivot table).



jemplo de Modelo con Relaciones

📘 Ejemplos de Relaciones en Modelos Laravel
==============================

🔹 1. hasOne (1:1)
Un usuario tiene un perfil.

// app/Models/User.php
class User extends Model
{
    use HasFactory;

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}

// app/Models/Profile.php
class Profile extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

------------------------------

🔹 2. hasMany (1:N)
Un post tiene muchos comentarios.

// app/Models/Post.php
class Post extends Model
{
    use HasFactory;

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

// app/Models/Comment.php
class Comment extends Model
{
    use HasFactory;

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}

------------------------------

🔹 3. belongsTo (N:1)
Ya incluido en Comment → Post.
Se usa en el modelo que tiene la clave foránea.

------------------------------

🔹 4. belongsToMany (N:M)
Un estudiante puede estar en muchos cursos, y un curso puede tener muchos estudiantes.
Requiere una tabla pivote: course_student.

// app/Models/Student.php
class Student extends Model
{
    use HasFactory;

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id');
    }
}

// app/Models/Course.php
class Course extends Model
{
    use HasFactory;

    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_student', 'course_id', 'student_id');
    }
}

==============================
✅ Resumen:
- hasOne → en el modelo que tiene un único relacionado.
- hasMany → en el modelo que posee múltiples registros.
- belongsTo → en el modelo con clave foránea.
- belongsToMany → en ambos modelos con tabla pivote.


==============================




<?php

namespace App\Http\Controllers;

use App\Models\AcademicDegree;
use Illuminate\Http\Request;

class AcademicDegreeController extends Controller
{
    public function index(Request $request)
    {
        $query = AcademicDegree::query();

        // Filtros
        if ($request->has('degree_name')) {
            $query->withName($request->degree_name);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginación
        $perPage = $request->get('per_page', 10);
        $degrees = $query->paginate($perPage);

        return response()->json($degrees);
    }

    public function show($id)
    {
        $degree = AcademicDegree::findOrFail($id);
        return response()->json($degree);
    }

    public function store(Request $request)
    {
        // Sin validación
        $degree = AcademicDegree::create($request->all());
        return response()->json($degree, 201);
    }

    public function update(Request $request, $id)
    {
        $degree = AcademicDegree::findOrFail($id);
        
        // Sin validación
        $degree->update($request->all());
        return response()->json($degree);
    }

    public function destroy($id)
    {
        $degree = AcademicDegree::findOrFail($id);
        $degree->delete();
        
        return response()->json(['message' => 'Academic degree deleted successfully']);
    }
}





# Obtener todos los recursos (paginados)
GET /api/resource?page=1&per_page=10

# Filtrar por campo
GET /api/resource?field=value

# Búsqueda por texto (si la API lo soporta)
GET /api/resource?search=palabra

# Ordenar resultados
GET /api/resource?sort_field=nombre&sort_order=asc

# Obtener un recurso por ID
GET /api/resource/{id}
