<?php

/**
 * @OA\Info(
 *     title="API Gestion Bancaire",
 *     version="1.0.0",
 *     description="API de gestion bancaire pour la liste des comptes."
 * )
 */

/**
 * @OA\Schema(
 *     schema="Compte",
 *     type="object",
 *     title="Compte",
 *     description="Modèle de compte bancaire",
 *     @OA\Property(property="id", type="string", description="ID unique du compte"),
 *     @OA\Property(property="numeroCompte", type="string", description="Numéro du compte"),
 *     @OA\Property(property="titulaire", type="string", description="Nom du titulaire"),
 *     @OA\Property(property="type", type="string", enum={"epargne", "cheque"}, description="Type de compte"),
 *     @OA\Property(property="solde", type="number", description="Solde du compte"),
 *     @OA\Property(property="devise", type="string", description="Devise du compte"),
 *     @OA\Property(property="dateCreation", type="string", format="date-time", description="Date de création"),
 *     @OA\Property(property="statut", type="string", enum={"actif", "bloque", "ferme"}, description="Statut du compte"),
 *     @OA\Property(property="motifBlocage", type="string", nullable=true, description="Motif de blocage"),
 *     @OA\Property(property="metadata", type="object", description="Métadonnées",
 *         @OA\Property(property="derniereModification", type="string", format="date-time"),
 *         @OA\Property(property="version", type="integer")
 *     )
 * )
 */

/**
 * @OA\Schema(
 *     schema="Pagination",
 *     type="object",
 *     title="Pagination",
 *     description="Informations de pagination",
 *     @OA\Property(property="currentPage", type="integer", description="Page actuelle"),
 *     @OA\Property(property="totalPages", type="integer", description="Total des pages"),
 *     @OA\Property(property="totalItems", type="integer", description="Total des éléments"),
 *     @OA\Property(property="itemsPerPage", type="integer", description="Éléments par page"),
 *     @OA\Property(property="hasNext", type="boolean", description="A une page suivante"),
 *     @OA\Property(property="hasPrevious", type="boolean", description="A une page précédente")
 * )
 */

/**
 * @OA\Schema(
 *     schema="Links",
 *     type="object",
 *     title="Links",
 *     description="Liens de navigation",
 *     @OA\Property(property="self", type="string", description="Lien vers la page actuelle"),
 *     @OA\Property(property="first", type="string", description="Lien vers la première page"),
 *     @OA\Property(property="last", type="string", description="Lien vers la dernière page"),
 *     @OA\Property(property="next", type="string", nullable=true, description="Lien vers la page suivante")
 * )
 */