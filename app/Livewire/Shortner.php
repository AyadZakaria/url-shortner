<?php

namespace App\Livewire;

use App\Models\Short;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

class Shortner extends Component
{
    use WithPagination;

    public $originalUrl;
    public $shortenedUrl;
    public $Expiration_date = null;
    public $isExpirable = false;
    public $isValidLink = true;
    public $ShowHistory = false;

    public function toggleShowHistory()
    {
        $this->ShowHistory = !$this->ShowHistory;
    }

    public function toggleCheck()
    {
        $this->isExpirable = !$this->isExpirable;
    }

    private function getRandomString($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $string;
    }

    public function shortenUrl()
    {
        $this->validate([
            "originalUrl" => "required"
        ], ["required" => "Saisir votre lien..."]);

        $shortHash = $this->getRandomString();
        $selectedDate = $this->Expiration_date;

        if ($this->isExpirable && $this->Expiration_date !== null && filter_var($this->originalUrl, FILTER_VALIDATE_URL)) {
            Short::create([
                "hash" => $shortHash,
                "original_url" => $this->originalUrl,
                "is_expirable" => true,
                "expiration_date" => $selectedDate,
            ]);
            $this->isValidLink == true;
        } else if (!filter_var($this->originalUrl, FILTER_VALIDATE_URL)) {
            $this->isValidLink = false;
        } else if (filter_var($this->originalUrl, FILTER_VALIDATE_URL)) {
            Short::create([
                'hash' => $shortHash,
                'original_url' => $this->originalUrl,
            ]);
            $this->isValidLink == true;
        }

        $this->originalUrl = "";
    }

    public function Archive($id)
    {
        $short = Short::find($id);
        $short->expired = true;
        $short->save();
        return redirect()->to('/dashboard');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $shortsQuery = Short::query();

        if ($this->ShowHistory) {
            $shortsQuery->where('expired', true);
        } else {
            $shortsQuery->where('expired', false);
        }

        $shorts = $shortsQuery->paginate(5);

        return view('livewire.shortner', ["shorts" => $shorts]);
    }
}
