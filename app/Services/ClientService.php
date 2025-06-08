<?php

namespace App\Services;

use App\Models\Client;
use App\Repositories\ClientRepository;
use Illuminate\Database\Eloquent\Collection;

class ClientService
{
    public function __construct(private ClientRepository $clientRepository)
    {
    }

    public function getAllClients(): Collection
    {
        return $this->clientRepository->all();
    }

    public function createClient(array $data): Client
    {
        return $this->clientRepository->create($data);
    }

    public function updateClient(Client $client, array $data): Client
    {
        return $this->clientRepository->update($client, $data);
    }

    public function deleteClient(Client $client): bool
    {
        return $this->clientRepository->delete($client);
    }
}