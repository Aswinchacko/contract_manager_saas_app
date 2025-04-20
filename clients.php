<?php
require_once 'includes/config.php';
requireAuth();

// Get user's clients
$userClients = $clients->find(['user_id' => $_SESSION['user_id']])->toArray();

// Calculate stats
$totalClients = count($userClients);
$activeClients = count(array_filter($userClients, fn($c) => $c['status'] === 'active'));
$totalContracts = 0;
$totalRevenue = 0;

foreach ($userClients as $client) {
    $clientContracts = $contracts->find(['client_id' => $client['_id']])->toArray();
    $totalContracts += count($clientContracts);
    $totalRevenue += array_sum(array_map(fn($c) => floatval(str_replace(['$', ','], '', $c['amount'])), $clientContracts));
}

$page_title = 'Clients';
include 'includes/header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold text-gray-900">Clients</h1>
            <p class="mt-2 text-sm text-gray-700">Manage your client relationships and view contract history.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <button type="button" onclick="openClientModal()"
                class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Add Client
            </button>
        </div>
    </div>

    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Company</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Phone</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Active Contracts</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <?php foreach ($userClients as $client): ?>
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                        <?php echo htmlspecialchars($client['name']); ?>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <?php echo htmlspecialchars($client['company'] ?? 'N/A'); ?>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <?php echo htmlspecialchars($client['email']); ?>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <?php echo htmlspecialchars($client['phone'] ?? 'N/A'); ?>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <?php
                                        $activeContracts = $contracts->countDocuments([
                                            'client_id' => (string)$client['_id'],
                                            'status' => 'active'
                                        ]);
                                        echo $activeContracts;
                                        ?>
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <a href="view-client.php?id=<?php echo $client['_id']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-4">View</a>
                                        <a href="edit-client.php?id=<?php echo $client['_id']; ?>" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/client-modal.php'; ?>
<?php include 'includes/footer.php'; ?> 