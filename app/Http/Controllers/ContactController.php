<?php
namespace App\Http\Controllers;

use App\Services\ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index()
    {
        return $this->contactService->getAllContacts();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:contacts',
            'phone' => 'required|string|max:15',
        ]);

        return $this->contactService->createContact($data);
    }

    public function show($id)
    {
        return $this->contactService->getContactById($id);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|unique:contacts,email,' . $id,
            'phone' => 'string|max:15',
        ]);

        return $this->contactService->updateContact($id, $data);
    }

    public function destroy($id)
    {
        return response()->json([
            'success' => $this->contactService->deleteContact($id),
        ]);
    }
}
