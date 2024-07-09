<?php

use App\Infrastrucutre\Service\GetIP;
use App\Infrastrucutre\Service\JwtManager;
use App\Core\Domain\Service\GetIPInterface;
use App\Core\Domain\Service\JwtManagerInterface;
use App\Infrastrucutre\Repository\SqlTagRepository;
use App\Infrastrucutre\Repository\SqlFormRepository;
use App\Infrastrucutre\Repository\SqlUserRepository;
use App\Infrastrucutre\Repository\SqlKaryaRepository;
use App\Core\Domain\Repository\TagRepositoryInterface;
use App\Core\Domain\Repository\FormRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Infrastrucutre\Repository\SqlSenimanRepository;
use App\Core\Domain\Repository\KaryaRepositoryInterface;
use App\Infrastrucutre\Repository\SqlKaryaTagRepository;
use App\Core\Domain\Repository\SenimanRepositoryInterface;
use App\Core\Domain\Repository\KaryaTagRepositoryInterface;
use App\Infrastrucutre\Repository\SqlPasswordResetRepository;
use App\Core\Domain\Repository\PasswordResetRepositoryInterface;


/** @var Application $app */

$app->singleton(UserRepositoryInterface::class, SqlUserRepository::class);
$app->singleton(JwtManagerInterface::class, JwtManager::class);
$app->singleton(GetIPInterface::class, GetIP::class);
$app->singleton(PasswordResetRepositoryInterface::class, SqlPasswordResetRepository::class);
$app->singleton(SenimanRepositoryInterface::class, SqlSenimanRepository::class);
$app->singleton(KaryaRepositoryInterface::class, SqlKaryaRepository::class);
$app->singleton(TagRepositoryInterface::class, SqlTagRepository::class);
$app->singleton(KaryaTagRepositoryInterface::class, SqlKaryaTagRepository::class);
$app->singleton(FormRepositoryInterface::class, SqlFormRepository::class);
