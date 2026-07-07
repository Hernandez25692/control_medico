<?php

namespace Database\Seeders;

use App\Models\Concepto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ConceptoSeeder extends Seeder
{
    public function run(): void
    {
        $conceptos = [
            'Menores de 1 Mes 1a. Vez',
            'Menores de 1 Mes Subsiguiente',
            '1 Mes a 1 año de 1a. Vez',
            '1 Mes a 1 Año Subsiguiente',
            '1 - 4 Años 1a. Vez',
            '1 - 4 Años Subsiguiente',
            '5 - 9 Años 1a. Vez',
            '5 - 9 Años Subsiguiente',
            '10 - 14 Años 1a. Vez',
            '10 - 14 Años Subsiguiente',
            '15 - 19 Años 1a. Vez',
            '15 - 19 Años Subsiguiente',
            '20 - 49 Años 1a. Vez',
            '20 - 49 Años Subsiguiente',
            '50 - 59 Años 1a. Vez',
            '50 - 59 Años Subsiguiente',
            '60 y + años 1a. Vez',
            '60 y  + años subsiguiente',
            'Total de Pacientes Atendidos',
            'Nº.Atenciones de Mujeres',
            'Nº. Atenciones de Hombres',
            'Nº. Consultas Expontaneas',
            'Nº. Consultas Referidas',
            'Detección de Sintomáticos Respiratorios',
            'Detección de Cáncer Cervico Uterino',
            'Embarazadas Nuevas',
            'Embarazadas en Control',
            'Controles Puerperales',
            'Anticonceptivo Oral 1 Ciclo',
            'Anticonceptivo Oral 3 Ciclo',
            'Anticonceptivo Oral 6 Ciclo',
            'Condones 10 Unidades',
            'Condones 30 Unidades',
            'Depo provera Aplicadas',
            'DIU insertados',
            'Nº. Usuarias utilizando el Método de Días Fijos (Collar)',
            'Implante Sub Dérmico',
            'Nº. Niños/as menores de 5 años con Diarrea',
            'Nº. Niños/as menores de 5 años con Diarrea que acuden a cita de seguimiento',
            'Nº. Niños/as menores de 5 años con Deshidratación Rehidratados en la US',
            'Nº. Niños/as menores de 5 años con Neumonía Nuevos en el Año',
            'Nº. Niños/as menores de 5 años con Neumonía que acuden a su cita de Seguimiento',
            'Nº. Niños/as menores de 5 años con algún grado de Síndrome Anémico Diagnosticado por Laboratorio',
            'Total de Niños/as Menores de 5 años Atendidos',
            'Nº. Niños/as menores de 5 años con Crecimiento Adecuado',
            'Nº. Niños/as menores de 5 años con Crecimiento Inadecuado',
            'Nº. Niños/as menores de 5 años con Bajo Percentil 3',
            'Nº. Niños/as menores de 5 años con Daño Nutricional Severo',
            'Nº. Niños/as menores de 5 años con Discapacidad Nuevos en el Año',
            'Nº. Niños/as menores de 5 años con Probable Alteración del Desarrollo',
            'Atención Prenatal Nueva en las primeras 12 SG',
            'Atención Puerperal Nueva en los  primeros 10 días',
            'Otras Actividades de Planificación Familiar',
        ];

        foreach ($conceptos as $index => $nombre) {
            Concepto::updateOrCreate(
                ['codigo' => 'CON' . str_pad($index + 1, 3, '0', STR_PAD_LEFT)],
                [
                    'nombre' => $nombre,
                    'descripcion' => $nombre,
                    'orden' => $index + 1,
                    'activo' => true,
                ]
            );
        }
    }
}
