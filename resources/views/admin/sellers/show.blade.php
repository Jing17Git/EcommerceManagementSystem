<x-admin-layout>
<x-slot name="header">Seller Application Details</x-slot>

<style>
  .sa-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 1px 4px rgba(0,0,0,.08), 0 4px 16px rgba(0,0,0,.06);
    overflow: hidden;
    margin-bottom: 1.5rem;
  }

  .sa-card-header {
    padding: 1.25rem 1.5rem;
    background: #f8f9fb;
    border-bottom: 1px solid #e5e7eb;
    font-weight: 700;
    font-size: 1.1rem;
    color: #374151;
  }

  .sa-card-body {
    padding: 1.5rem;
  }

  .info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.25rem;
  }

  .info-item label {
    display: block;
    font-size: .8rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: .05em;
    margin-bottom: .4rem;
  }

  .info-item .value {
    font-size: .95rem;
    color: #1f2937;
    font-weight: 500;
  }

  .badge {
    display: inline-block;
    padding: .35em .85em;
    border-radius: 999px;
    font-size: .85rem;
    font-weight: 600;
    text-transform: capitalize;
  }
  .badge-pending  { background: #fef3c7; color: #92400e; }
  .badge-approved { background: #d1fae5; color: #065f46; }
  .badge-rejected { background: #fee2e2; color: #991b1b; }

  .document-preview {
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 1rem;
    text-align: center;
    background: #f9fafb;
  }

  .document-preview img {
    max-width: 100%;
    max-height: 400px;
    border-radius: 6px;
    margin-bottom: .75rem;
  }

  .btn {
    display: inline-block;
    padding: .6rem 1.25rem;
    border-radius: 8px;
    font-size: .9rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: opacity .15s, transform .1s;
    margin-right: .5rem;
  }
  .btn:hover { opacity: .85; transform: translateY(-1px); }
  
  .btn-approve { background: #10b981; color: white; }
  .btn-reject  { background: #f59e0b; color: white; }
  .btn-delete  { background: #ef4444; color: white; }
  .btn-back    { background: #6b7280; color: white; }

  .alert {
    padding: 1rem 1.25rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    font-size: .9rem;
  }
  .alert-danger { background: #fee2e2; color: #991b1b; border-left: 4px solid #dc2626; }
  .alert-success { background: #d1fae5; color: #065f46; border-left: 4px solid #10b981; }
</style>

<div>
  <a href="{{ route('admin.sellers.index') }}" class="btn btn-back">
    <i class="fas fa-arrow-left"></i> Back to Applications
  </a>
</div>

<div style="margin-top: 1.5rem;">
  @if($application->status === 'rejected' && $application->rejection_reason)
    <div class="alert alert-danger">
      <strong>Rejection Reason:</strong> {{ $application->rejection_reason }}
    </div>
  @endif

  @if($application->status === 'approved')
    <div class="alert alert-success">
      <strong>Status:</strong> This application has been approved.
    </div>
  @endif

  <div class="sa-card">
    <div class="sa-card-header">Application Information</div>
    <div class="sa-card-body">
      <div class="info-grid">
        <div class="info-item">
          <label>Applicant</label>
          <div class="value">{{ $application->user->name }}</div>
        </div>
        <div class="info-item">
          <label>Email</label>
          <div class="value">{{ $application->user->email }}</div>
        </div>
        <div class="info-item">
          <label>Status</label>
          <div class="value">
            <span class="badge badge-{{ $application->status }}">
              {{ ucfirst($application->status) }}
            </span>
          </div>
        </div>
        <div class="info-item">
          <label>Submitted At</label>
          <div class="value">{{ $application->created_at->format('F d, Y h:i A') }}</div>
        </div>
      </div>
    </div>
  </div>

  <div class="sa-card">
    <div class="sa-card-header">Business Information</div>
    <div class="sa-card-body">
      <div class="info-grid">
        <div class="info-item">
          <label>Business Name</label>
          <div class="value">{{ $application->business_name }}</div>
        </div>
        <div class="info-item">
          <label>Business Email</label>
          <div class="value">{{ $application->business_email }}</div>
        </div>
        <div class="info-item">
          <label>Business Phone</label>
          <div class="value">{{ $application->business_phone }}</div>
        </div>
        <div class="info-item">
          <label>Business Permit Name</label>
          <div class="value">{{ $application->business_permit_name ?? 'N/A' }}</div>
        </div>
        <div class="info-item">
          <label>ID Card Name</label>
          <div class="value">{{ $application->id_card_name ?? 'N/A' }}</div>
        </div>
        <div class="info-item" style="grid-column: 1 / -1;">
          <label>Business Address</label>
          <div class="value">{{ $application->business_address }}</div>
        </div>
        <div class="info-item">
          <label>Permit Expiry Date</label>
          <div class="value">
            @if($application->permit_expiry_date)
              {{ $application->permit_expiry_date->format('F d, Y') }}
              @if($application->permit_expiry_date->isPast())
                <span style="color: #dc2626; font-weight: 700;"> (EXPIRED)</span>
              @endif
            @else
              N/A
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  @if($application->business_permit || $application->id_card)
  <div class="sa-card">
    <div class="sa-card-header">Uploaded Documents</div>
    <div class="sa-card-body">
      <div class="info-grid">
        @if($application->business_permit)
        <div class="info-item">
          <label>Business Permit</label>
          <div class="document-preview">
            @if(in_array(pathinfo($application->business_permit, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
              <img src="{{ asset('storage/' . $application->business_permit) }}" alt="Business Permit">
            @else
              <i class="fas fa-file-pdf" style="font-size: 3rem; color: #dc2626; margin-bottom: .5rem;"></i>
              <div style="font-size: .9rem; color: #6b7280;">PDF Document</div>
            @endif
            <a href="{{ asset('storage/' . $application->business_permit) }}" target="_blank" class="btn btn-back" style="margin-top: .75rem;">
              <i class="fas fa-download"></i> Download
            </a>
          </div>
        </div>
        @endif

        @if($application->id_card)
        <div class="info-item">
          <label>ID Card</label>
          <div class="document-preview">
            @if(in_array(pathinfo($application->id_card, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
              <img src="{{ asset('storage/' . $application->id_card) }}" alt="ID Card">
            @else
              <i class="fas fa-file-pdf" style="font-size: 3rem; color: #dc2626; margin-bottom: .5rem;"></i>
              <div style="font-size: .9rem; color: #6b7280;">PDF Document</div>
            @endif
            <a href="{{ asset('storage/' . $application->id_card) }}" target="_blank" class="btn btn-back" style="margin-top: .75rem;">
              <i class="fas fa-download"></i> Download
            </a>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
  @endif

  @if($application->status == 'pending')
  <div class="sa-card">
    <div class="sa-card-header">Actions</div>
    <div class="sa-card-body">
      <form action="{{ route('admin.sellers.approve', $application) }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="btn btn-approve" onclick="return confirm('Approve this application?')">
          <i class="fas fa-check"></i> Approve Application
        </button>
      </form>

      <form action="{{ route('admin.sellers.reject', $application) }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="btn btn-reject" onclick="return confirm('Reject this application?')">
          <i class="fas fa-times"></i> Reject Application
        </button>
      </form>

      <form action="{{ route('admin.sellers.destroy', $application) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-delete" onclick="return confirm('Delete this application permanently?')">
          <i class="fas fa-trash"></i> Delete Application
        </button>
      </form>
    </div>
  </div>
  @endif
</div>

</x-admin-layout>
