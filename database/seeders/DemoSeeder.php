<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Reservation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // --- Admin ---
        $admin = User::create([
            'name'     => 'Admin Principal',
            'email'    => 'admin@gestionmed.ci',
            'role'     => 'admin',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // --- Médecins ---
        $med1 = User::create([
            'name'     => 'Dr. Konan Akissi',
            'email'    => 'dr.konan@gestionmed.ci',
            'role'     => 'medecin',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $med2 = User::create([
            'name'     => 'Dr. Bamba Oumar',
            'email'    => 'dr.bamba@gestionmed.ci',
            'role'     => 'medecin',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // --- Patients ---
        $pat1 = User::create([
            'name'     => 'Moussa Traoré',
            'email'    => 'patient@gestionmed.ci',
            'role'     => 'patient',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $pat2 = User::create([
            'name'     => 'Aminata Koné',
            'email'    => 'patient2@gestionmed.ci',
            'role'     => 'patient',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // --- Services ---
        $s1 = Service::create([
            'titre'       => 'Consultation générale',
            'description' => 'Consultation médicale de base avec examen clinique complet.',
            'prix'        => 15000,
            'duree'       => 30,
            'statut'      => 'actif',
            'medecin_id'  => $med1->id,
        ]);

        $s2 = Service::create([
            'titre'       => 'Consultation pédiatrique',
            'description' => 'Consultation spécialisée pour les nourrissons et les enfants de 0 à 15 ans.',
            'prix'        => 20000,
            'duree'       => 45,
            'statut'      => 'actif',
            'medecin_id'  => $med2->id,
        ]);

        $s3 = Service::create([
            'titre'       => 'Suivi diabétique',
            'description' => 'Consultation de suivi pour les patients diabétiques, glycémie et conseils alimentaires.',
            'prix'        => 18000,
            'duree'       => 40,
            'statut'      => 'actif',
            'medecin_id'  => $med1->id,
        ]);

        $s4 = Service::create([
            'titre'       => 'Imagerie médicale',
            'description' => 'Radio, échographie et autres examens d\'imagerie diagnostique.',
            'prix'        => 35000,
            'duree'       => 60,
            'statut'      => 'actif',
            'medecin_id'  => null,
        ]);

        $s5 = Service::create([
            'titre'       => 'Vaccination',
            'description' => 'Vaccins adultes et enfants selon le calendrier vaccinal national.',
            'prix'        => 8000,
            'duree'       => 15,
            'statut'      => 'actif',
            'medecin_id'  => $med2->id,
        ]);

        // --- Réservations de démonstration ---
        Reservation::create([
            'user_id'          => $pat1->id,
            'service_id'       => $s1->id,
            'date_reservation' => now()->addDays(2)->format('Y-m-d'),
            'heure_reservation'=> '09:00',
            'statut'           => 'en_attente',
            'commentaire'      => 'Première consultation, douleurs abdominales.',
        ]);

        Reservation::create([
            'user_id'          => $pat1->id,
            'service_id'       => $s3->id,
            'date_reservation' => now()->addDays(5)->format('Y-m-d'),
            'heure_reservation'=> '10:30',
            'statut'           => 'confirmee',
            'commentaire'      => null,
        ]);

        Reservation::create([
            'user_id'          => $pat2->id,
            'service_id'       => $s2->id,
            'date_reservation' => now()->addDay()->format('Y-m-d'),
            'heure_reservation'=> '14:00',
            'statut'           => 'en_attente',
            'commentaire'      => 'Enfant de 3 ans, fièvre persistante.',
        ]);

        Reservation::create([
            'user_id'          => $pat2->id,
            'service_id'       => $s5->id,
            'date_reservation' => now()->subDays(3)->format('Y-m-d'),
            'heure_reservation'=> '08:00',
            'statut'           => 'effectuee',
            'commentaire'      => null,
        ]);
    }
}
