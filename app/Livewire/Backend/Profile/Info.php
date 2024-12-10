<?php

namespace App\Livewire\Backend\Profile;

use App\Models\Image;
use App\Models\Profile;
use App\Traits\HasMediaUpload;
use Livewire\Attributes\On;
use Livewire\Component;

class Info extends Component
{
    use HasMediaUpload;

    public Profile $profile;

    public $image;

    public $resume;

    public string $resumePath;

    public string $imagePath = '';

    public string $message;

    public array $profileInfo = [];

    public function mount()
    {
        $this->getProfileInfo();
    }

    public function getProfileInfo()
    {
        $this->profile = Profile::with('image')->first();
        $this->setProfileInfo($this->profile);
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => [
                'image',
                'max:5120', // 5MB max file size
                'mimes:jpeg,jpg,webp,png,gif',
            ],
        ], [
            'image.image' => 'The file must be an image.',
            'image.max' => 'Image size should not exceed 5MB.',
            'image.mimes' => 'The image must be one of these types: jpeg, jpg, webp, png, gif.',
        ]);

        $this->imagePath = $this->upload($this->image, 'profile');
    }

    public function updatedResume()
    {
        $this->validate([
            'resume' => [
                'file',
                'max:5120',
                'mimes:pdf',
            ],
        ], [
            'resume.file' => 'The uploaded file must be valid.',
            'resume.max' => 'The file size should not exceed 5MB.',
            'resume.mimes' => 'Only PDF files are allowed.',
        ]);

        $this->resumePath = $this->upload($this->resume, 'profile');
    }

    public function setProfileInfo(Profile $profile)
    {
        $this->profileInfo = [
            'phone' => $profile->phone,
            'github' => $profile->github,
            'twitter' => $profile->twitter,
            'linkedin' => $profile->linkedin,
            'intro' => $profile->intro,
            'designation' => $profile->designation,
        ];
    }

    public function render()
    {
        return view('livewire.backend.profile.info')->layout('layouts.admin');
    }

    public function update()
    {
        $this->validate();

        //Update profile info
        $this->profile->phone = $this->profileInfo['phone'];
        $this->profile->github = $this->profileInfo['github'];
        $this->profile->twitter = $this->profileInfo['twitter'];
        $this->profile->linkedin = $this->profileInfo['linkedin'];
        $this->profile->designation = $this->profileInfo['designation'];
        $this->profile->intro = $this->profileInfo['intro'];
        $this->profile->save();

        //If image uploaded
        if ($this->image) {
            //delete old image if exists
            if ($this->profile->image) {
                $this->removeUploadedFile($this->profile->image->image_path);

                //Delete old image from db
                $this->profile->image()->delete();
            }

            //Save image in the database
            $this->profile->image()->create([
                'image_path' => $this->imagePath,
            ]);
        }

        //If resume uploaded
        if ($this->resume) {
            //delete old resume if exists
            if ($this->profile->resume_path) {
                $this->removeUploadedFile($this->profile->resume_path);
            }

            //Update the resume
            $this->profile->update([
                'resume_path' => $this->resumePath,
            ]);
        }

        $this->image = '';
        $this->imagePath = '';
        $this->resume = '';
        $this->resumePath = '';
        $this->message = 'Profile Updated Successfully!';
        $this->dispatch('updated');
        $this->dispatch('refresh-component');
    }

    #[On('refresh-component')]
    public function refreshComponent()
    {
        $this->dispatch('$refresh');
    }

    public function deleteImage(int $id)
    {
        $image = Image::findOrFail($id);
        $this->removeUploadedFile($image->image_path);
        $image->delete();
        $this->message = 'Profile Image Deleted Successfully!';
        $this->dispatch('updated');
    }

    public function removeImage()
    {
        if ($this->imagePath) {
            $this->removeUploadedFile($this->imagePath);
            $this->imagePath = '';
            $this->image = '';
        }
    }

    public function removeResume()
    {
        if ($this->resumePath) {
            $this->removeUploadedFile($this->resumePath);
            $this->resumePath = '';
            $this->resume = '';
        }
    }

    protected function rules()
    {
        return [
            'profileInfo.phone' => 'required|string|min:6|max:15',
            'profileInfo.github' => 'required|url|max:255',
            'profileInfo.twitter' => 'required|url|max:255',
            'profileInfo.linkedin' => 'required|url|max:255',
            'profileInfo.designation' => 'required|string|max:255',
            'profileInfo.intro' => 'required|string',
        ];
    }
}