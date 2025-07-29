<?php
namespace App\Console\Commands;

use App\Models\BranchEmail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;

class ImportBranchEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:branch-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import branch emails from a CSV file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath    = storage_path('app/branch_emails.csv');
        $invalidPath = storage_path('app/invalid_branch_emails.csv');

        if (! file_exists($filePath)) {
            $this->error("CSV file not found at: $filePath");
            return;
        }

        $states     = config('constants.states');
        $citiesList = config('constants.citiesList');

        $handle      = fopen($filePath, 'r');
        $invalidRows = [];

        $rowNumber = 0;
        while (($data = fgetcsv($handle)) !== false) {
            $rowNumber++;

            if ($rowNumber == 1) {
                continue;
            }
            // skip header

            [$zone, $state, $city, $branchName, $email] = $data;

            $errors = [];

            if (! in_array($state, $states)) {
                $errors[] = "Invalid state";
            }

            if (! isset($citiesList[$state]) || ! in_array($city, $citiesList[$state])) {
                $errors[] = "Invalid city";
            }

            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email";
            }

            if ($errors) {
                $invalidRows[] = array_merge($data, [implode('; ', $errors)]);
                continue;
            }

            BranchEmail::create([
                'zone_name'        => $zone,
                'state'            => $state,
                'city'             => $city,
                'branch_name'      => $branchName,
                'commercial_email' => $email,
            ]);
        }

        fclose($handle);

        // Save invalid rows
        if ($invalidRows) {
            $fp = fopen($invalidPath, 'w');
            fputcsv($fp, ['Zone_Name', 'State', 'City', 'BranchName', 'Branch Commercial email id', 'Error']);
            foreach ($invalidRows as $row) {
                fputcsv($fp, $row);
            }
            fclose($fp);
            $this->warn("Invalid rows saved to: $invalidPath");
        }

        $this->info("Import completed with $rowNumber rows processed.");
    }
}
