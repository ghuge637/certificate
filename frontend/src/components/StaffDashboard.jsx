import React, { useState, useEffect } from 'react';

export default function StaffDashboard({ user, onLogout }) {
  // Current logged in desk (defaults to user.deskNo or 1 for Desk 1 - Student Section)
  const [currentDeskNo, setCurrentDeskNo] = useState(user.deskNo || user.desk_no || 1);
  
  // Navigation View State: 'HOME', 'BONAFIDE_LIST', 'LC_LIST', 'VERIFICATION_VIEW', 'REJECTED_LIST'
  const [currentView, setCurrentView] = useState('HOME');
  
  const [pendingBonafides, setPendingBonafides] = useState([]);
  const [pendingLcClearances, setPendingLcClearances] = useState([]);
  const [rejectedApplications, setRejectedApplications] = useState([]);
  const [selectedStudent, setSelectedStudent] = useState(null);
  
  // Modal States for Reject and Failed popups (from stud_sect_action.php)
  const [showRejectModal, setShowRejectModal] = useState(false);
  const [showFailedModal, setShowFailedModal] = useState(false);
  const [rejectionReason, setRejectionReason] = useState('');
  const [failedValue, setFailedValue] = useState('');

  const [actionMessage, setActionMessage] = useState('');
  const [loading, setLoading] = useState(false);

  const API_BASE = 'http://localhost:8080';

  const DESK_NAMES = {
    1: 'Student Section Dashboard (Desk 1)',
    2: 'Scholarship Section Dashboard (Desk 2)',
    3: 'Accounts Section Dashboard (Desk 3)',
    4: 'Library Section Dashboard (Desk 4)',
    5: 'Placement Cell Dashboard (Desk 5)',
    6: 'Workshop Clearance Dashboard (Desk 6)',
    7: 'Computer HOD Dashboard (Desk 7)',
    8: 'ENTC HOD Dashboard (Desk 8)',
    9: 'AIDS HOD Dashboard (Desk 9)',
    10: 'Mechanical HOD Dashboard (Desk 10)',
    11: 'Principal Office Dashboard (Desk 11)'
  };

  useEffect(() => {
    fetchPendingRequests(currentDeskNo);
    fetchRejectedApplications();
  }, [currentDeskNo]);

  const fetchPendingRequests = async (deskNo) => {
    setLoading(true);
    try {
      // Fetch Bonafide requests for Desk 1
      let bRes;
      try {
        bRes = await fetch(`${API_BASE}/api/v1/bonafide/pending`);
      } catch (err) {
        bRes = await fetch('/api/v1/bonafide/pending');
      }
      if (bRes && bRes.ok) {
        const bData = await bRes.json();
        setPendingBonafides(bData || []);
      }

      // Fetch Desk-specific pending LC Clearances directly from DB
      let lcRes;
      try {
        lcRes = await fetch(`${API_BASE}/api/v1/lc/pending-clearances?deskNo=${deskNo}`);
      } catch (err) {
        lcRes = await fetch(`/api/v1/lc/pending-clearances?deskNo=${deskNo}`);
      }
      if (lcRes && lcRes.ok) {
        const lcData = await lcRes.json();
        setPendingLcClearances(lcData || []);
      } else {
        setPendingLcClearances([]);
      }
    } catch (err) {
      console.error('Error fetching data from database:', err);
      setPendingLcClearances([]);
    } finally {
      setLoading(false);
    }
  };

  const fetchRejectedApplications = async () => {
    try {
      let res;
      try {
        res = await fetch(`${API_BASE}/api/v1/lc/rejected-applications`);
      } catch (err) {
        res = await fetch('/api/v1/lc/rejected-applications');
      }
      if (res && res.ok) {
        const data = await res.json();
        setRejectedApplications(data || []);
      }
    } catch (err) {
      console.error(err);
    }
  };

  const handleApproveLcSection = async (clearanceId) => {
    if (!window.confirm('Do you want to Approve?')) return;
    
    // Remove from active queue immediately
    setPendingLcClearances(prev => prev.filter(item => item.id !== clearanceId));
    
    try {
      let res;
      const payload = { 
        clearanceId: clearanceId, 
        staffId: user.username || 'STF-101', 
        remark: 'Approved' 
      };
      try {
        res = await fetch(`${API_BASE}/api/v1/lc/approve-section`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
      } catch (err) {
        res = await fetch('/api/v1/lc/approve-section', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
      }
    } catch (err) {
      console.error(err);
    }

    setActionMessage(`Leaving Certificate approved at Desk ${currentDeskNo}! Application moved to Desk ${currentDeskNo + 1}.`);
    setSelectedStudent(null);
    setCurrentView('LC_LIST');
    fetchPendingRequests(currentDeskNo);
  };

  const handleRejectSubmit = async (e) => {
    e.preventDefault();
    if (!rejectionReason.trim()) {
      alert('Please provide a reason for rejection.');
      return;
    }
    if (!window.confirm(`Really you want to submit: ${rejectionReason}`)) return;

    if (!selectedStudent) return;
    const clearanceId = selectedStudent.id;

    // 1. Remove from active pending queue
    setPendingLcClearances(prev => prev.filter(item => item.id !== clearanceId));

    // 2. Send to backend REST endpoint
    try {
      const payload = { 
        clearanceId: clearanceId, 
        staffId: user.username || 'STF-101', 
        remark: rejectionReason 
      };
      try {
        await fetch(`${API_BASE}/api/v1/lc/reject-section`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
      } catch (err) {
        await fetch('/api/v1/lc/reject-section', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
      }
    } catch (err) {
      console.error(err);
    }

    setActionMessage(`Application rejected. It has been moved to Rejected Applications.`);
    setShowRejectModal(false);
    setRejectionReason('');
    setSelectedStudent(null);
    setCurrentView('REJECTED_LIST');
    fetchPendingRequests(currentDeskNo);
    fetchRejectedApplications();
  };

  const handleFailedSubmit = async (e) => {
    e.preventDefault();
    if (!failedValue.trim()) {
      alert('Please provide Failed value.');
      return;
    }
    if (!window.confirm(`Really you want to submit: ${failedValue}`)) return;

    if (!selectedStudent) return;
    const clearanceId = selectedStudent.id;

    // 1. Remove from active pending queue
    setPendingLcClearances(prev => prev.filter(item => item.id !== clearanceId));

    // 2. Send to backend REST endpoint
    try {
      const payload = { 
        clearanceId: clearanceId, 
        staffId: user.username || 'STF-101', 
        remark: `Failed: ${failedValue}` 
      };
      try {
        await fetch(`${API_BASE}/api/v1/lc/reject-section`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
      } catch (err) {
        await fetch('/api/v1/lc/reject-section', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
      }
    } catch (err) {
      console.error(err);
    }

    setActionMessage(`Application marked as Failed (${failedValue}) and moved to Rejected Applications.`);
    setShowFailedModal(false);
    setFailedValue('');
    setSelectedStudent(null);
    setCurrentView('REJECTED_LIST');
    fetchPendingRequests(currentDeskNo);
    fetchRejectedApplications();
  };

  const openStudentVerification = (studentItem) => {
    setSelectedStudent(studentItem);
    setCurrentView('VERIFICATION_VIEW');
  };

  return (
    <div style={{ minHeight: '100vh', background: '#f1f5f9', color: '#1e293b', fontFamily: 'Arial, sans-serif' }}>
      
      {/* 1. KEYSTONE BLUE HEADER BANNER */}
      <header style={{ background: '#0056b3', color: '#ffffff', padding: '0.85rem 2rem', display: 'flex', justifyContent: 'space-between', alignItems: 'center', boxShadow: '0 2px 8px rgba(0,0,0,0.15)' }}>
        <div style={{ display: 'flex', alignItems: 'center', gap: '1rem' }}>
          <div style={{ background: '#ffffff', borderRadius: '50%', width: '48px', height: '48px', display: 'flex', alignItems: 'center', justifyContent: 'center', fontWeight: 'bold', color: '#0056b3', fontSize: '20px', border: '2px solid #ffffff' }}>
            🎓
          </div>
          <div>
            <h1 style={{ fontSize: '1.4rem', fontWeight: '700', margin: 0 }}>Keystone School of Engineering</h1>
            <p style={{ fontSize: '0.8rem', color: '#e2e8f0', margin: 0 }}>Excellence in Technical Education Since 2012</p>
          </div>
        </div>

        <div style={{ display: 'flex', alignItems: 'center', gap: '1rem' }}>
          {/* Desk Switcher */}
          <select 
            value={currentDeskNo} 
            onChange={(e) => setCurrentDeskNo(Number(e.target.value))}
            style={{ background: '#ffffff', color: '#0056b3', padding: '0.4rem 0.8rem', borderRadius: '6px', fontWeight: 'bold', border: 'none', cursor: 'pointer' }}
          >
            <option value={1}>Desk 1 - Student Section</option>
            <option value={2}>Desk 2 - Scholarship Clearance</option>
            <option value={3}>Desk 3 - Accounts Section</option>
            <option value={4}>Desk 4 - Library Section</option>
            <option value={5}>Desk 5 - Placement Cell</option>
            <option value={6}>Desk 6 - Workshop Clearance</option>
            <option value={7}>Desk 7 - Computer HOD</option>
            <option value={8}>Desk 8 - ENTC HOD</option>
            <option value={9}>Desk 9 - AIDS HOD</option>
            <option value={10}>Desk 10 - Mechanical HOD</option>
            <option value={11}>Desk 11 - Principal Office</option>
          </select>

          <button 
            onClick={onLogout} 
            style={{ background: 'transparent', color: '#ffffff', border: '1px solid rgba(255,255,255,0.7)', padding: '0.4rem 1.2rem', borderRadius: '9999px', cursor: 'pointer', fontWeight: '600', fontSize: '0.85rem' }}
          >
            Logout 🚪
          </button>
        </div>
      </header>

      <main style={{ maxWidth: '1100px', margin: '2rem auto', padding: '0 1rem' }}>

        {actionMessage && (
          <div style={{ padding: '0.85rem 1.25rem', background: '#dcfce7', border: '1px solid #86efac', color: '#166534', borderRadius: '8px', marginBottom: '1.5rem', fontWeight: '600' }}>
            {actionMessage}
          </div>
        )}

        {/* VIEW 1: HOME DESK DASHBOARD */}
        {currentView === 'HOME' && (
          <div>
            <div style={{ background: 'linear-gradient(135deg, #2b82c9, #1d6fa5)', color: '#ffffff', padding: '2rem', borderRadius: '16px', marginBottom: '2rem', boxShadow: '0 8px 20px rgba(43, 130, 201, 0.25)', position: 'relative' }}>
              <h2 style={{ fontSize: '1.8rem', fontWeight: '700', marginBottom: '0.4rem' }}>{DESK_NAMES[currentDeskNo]}</h2>
              <p style={{ color: '#e0f2fe', fontSize: '0.95rem', marginBottom: '1.25rem' }}>Manage student requests and clearance records</p>
              
              <div style={{ display: 'inline-flex', alignItems: 'center', background: 'rgba(255,255,255,0.2)', padding: '0.4rem 1rem', borderRadius: '9999px', fontSize: '0.85rem', fontWeight: '600' }}>
                💻 Desk No: {currentDeskNo}
              </div>
            </div>

            {/* Action Cards matching desk role */}
            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(240px, 1fr))', gap: '1.5rem' }}>
              
              {/* Card 1: Bonafide Requests (Only for Desk 1) */}
              {currentDeskNo === 1 && (
                <div style={{ background: '#ffffff', borderRadius: '14px', padding: '1.5rem', border: '1px solid #e2e8f0', boxShadow: '0 4px 12px rgba(0,0,0,0.05)', textAlign: 'center', borderTop: '5px solid #22c55e' }}>
                  <h3 style={{ fontSize: '1rem', color: '#334155', marginBottom: '1.25rem', fontWeight: '700' }}>📄 Bonafide Requests</h3>
                  <button 
                    onClick={() => setCurrentView('BONAFIDE_LIST')} 
                    style={{ width: '100%', padding: '0.75rem', background: '#22c55e', color: '#ffffff', border: 'none', borderRadius: '8px', fontWeight: '700', cursor: 'pointer' }}
                  >
                    Bonafide ({pendingBonafides.length})
                  </button>
                </div>
              )}

              {/* Card 2: Leaving Certificate Requests */}
              <div style={{ background: '#ffffff', borderRadius: '14px', padding: '1.5rem', border: '1px solid #e2e8f0', boxShadow: '0 4px 12px rgba(0,0,0,0.05)', textAlign: 'center', borderTop: '5px solid #f97316' }}>
                <h3 style={{ fontSize: '1rem', color: '#334155', marginBottom: '1.25rem', fontWeight: '700' }}>🎓 Leaving Certificate Requests</h3>
                <button 
                  onClick={() => setCurrentView('LC_LIST')} 
                  style={{ width: '100%', padding: '0.75rem', background: '#f97316', color: '#ffffff', border: 'none', borderRadius: '8px', fontWeight: '700', cursor: 'pointer' }}
                >
                  Leaving Certificate ({pendingLcClearances.length})
                </button>
              </div>

              {/* Card 3: Rejected Applications */}
              <div style={{ background: '#ffffff', borderRadius: '14px', padding: '1.5rem', border: '1px solid #e2e8f0', boxShadow: '0 4px 12px rgba(0,0,0,0.05)', textAlign: 'center', borderTop: '5px solid #ef4444' }}>
                <h3 style={{ fontSize: '1rem', color: '#334155', marginBottom: '1.25rem', fontWeight: '700' }}>❌ Rejected Applications</h3>
                <button 
                  onClick={() => setCurrentView('REJECTED_LIST')} 
                  style={{ width: '100%', padding: '0.75rem', background: '#ef4444', color: '#ffffff', border: 'none', borderRadius: '8px', fontWeight: '700', cursor: 'pointer' }}
                >
                  Rejected ({rejectedApplications.length})
                </button>
              </div>

              {/* Card 4: Update Records */}
              <div style={{ background: '#ffffff', borderRadius: '14px', padding: '1.5rem', border: '1px solid #e2e8f0', boxShadow: '0 4px 12px rgba(0,0,0,0.05)', textAlign: 'center', borderTop: '5px solid #8b5cf6' }}>
                <h3 style={{ fontSize: '1rem', color: '#334155', marginBottom: '1.25rem', fontWeight: '700' }}>🗄️ Update Records</h3>
                <button 
                  onClick={() => alert('Student records up to date.')} 
                  style={{ width: '100%', padding: '0.75rem', background: '#8b5cf6', color: '#ffffff', border: 'none', borderRadius: '8px', fontWeight: '700', cursor: 'pointer' }}
                >
                  UPDATE
                </button>
              </div>

            </div>
          </div>
        )}

        {/* VIEW 2: REQUESTS FOR LC TABLE LIST (multi_section_actions.php) */}
        {currentView === 'LC_LIST' && (
          <div style={{ background: '#ffffff', borderRadius: '12px', padding: '2rem', boxShadow: '0 4px 16px rgba(0,0,0,0.06)', border: '1px solid #e2e8f0' }}>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '1.5rem' }}>
              <button 
                onClick={() => setCurrentView('HOME')} 
                style={{ padding: '0.4rem 1rem', background: '#ffffff', border: '1px solid #000000', borderRadius: '6px', cursor: 'pointer', fontWeight: '600', fontSize: '0.85rem' }}
              >
                ← Back to Dashboard
              </button>
              
              <button 
                onClick={() => setCurrentView('REJECTED_LIST')}
                style={{ padding: '0.4rem 1rem', background: '#ffffff', border: '1px solid #000000', borderRadius: '6px', cursor: 'pointer', fontSize: '0.85rem', fontWeight: '600' }}
              >
                Rejected Applications ({rejectedApplications.length})
              </button>
            </div>

            <h2 style={{ textAlign: 'center', fontSize: '1.6rem', fontWeight: '800', margin: '1.5rem 0', letterSpacing: '1px', textTransform: 'uppercase' }}>
              REQUESTS FOR LC - DESK {currentDeskNo}
            </h2>

            <table style={{ width: '100%', borderCollapse: 'collapse', marginTop: '1.5rem' }}>
              <thead>
                <tr style={{ background: '#9e9e9e', color: '#ffffff', textAlign: 'center', fontSize: '0.95rem' }}>
                  <th style={{ padding: '1rem', border: '1px solid #cbd5e1' }}>PRN No</th>
                  <th style={{ padding: '1rem', border: '1px solid #cbd5e1' }}>Student Name</th>
                  <th style={{ padding: '1rem', border: '1px solid #cbd5e1' }}>Status</th>
                  <th style={{ padding: '1rem', border: '1px solid #cbd5e1' }}>Get Action</th>
                </tr>
              </thead>
              <tbody>
                {pendingLcClearances.length === 0 ? (
                  <tr>
                    <td colSpan="4" style={{ padding: '2rem', color: '#64748b', textAlign: 'center' }}>
                      No request for LC at Desk {currentDeskNo}
                    </td>
                  </tr>
                ) : (
                  pendingLcClearances.map(item => (
                    <tr key={item.id} style={{ textAlign: 'center', background: '#ffffff', borderBottom: '1px solid #e2e8f0' }}>
                      <td style={{ padding: '1rem', border: '1px solid #e2e8f0' }}>{item.prnno}</td>
                      <td style={{ padding: '1rem', border: '1px solid #e2e8f0', fontWeight: '600' }}>{item.studentName}</td>
                      <td style={{ padding: '1rem', border: '1px solid #e2e8f0' }}>Pending</td>
                      <td style={{ padding: '1rem', border: '1px solid #e2e8f0' }}>
                        <button 
                          onClick={() => openStudentVerification(item)} 
                          style={{ padding: '0.35rem 1.25rem', background: '#ffffff', border: '1px solid #000000', borderRadius: '6px', cursor: 'pointer', fontWeight: '600', fontSize: '0.9rem' }}
                        >
                          View
                        </button>
                      </td>
                    </tr>
                  ))
                )}
              </tbody>
            </table>
          </div>
        )}

        {/* VIEW 2-B: REJECTED APPLICATIONS LIST (rejected_application.php) */}
        {currentView === 'REJECTED_LIST' && (
          <div style={{ background: '#ffffff', borderRadius: '12px', padding: '2rem', boxShadow: '0 4px 16px rgba(0,0,0,0.06)', border: '1px solid #e2e8f0' }}>
            <button onClick={() => setCurrentView('LC_LIST')} style={{ padding: '0.4rem 1rem', background: '#ffffff', border: '1px solid #000000', borderRadius: '6px', cursor: 'pointer', fontWeight: '600', marginBottom: '1.5rem' }}>
              ← Back to LC Requests List
            </button>
            <h2 style={{ textAlign: 'center', fontSize: '1.6rem', fontWeight: '800', marginBottom: '1.5rem', textTransform: 'uppercase', color: '#ef4444' }}>
              REJECTED APPLICATIONS
            </h2>
            <table style={{ width: '100%', borderCollapse: 'collapse' }}>
              <thead>
                <tr style={{ background: '#ef4444', color: '#ffffff', textAlign: 'center' }}>
                  <th style={{ padding: '1rem', border: '1px solid #dc2626' }}>PRN No</th>
                  <th style={{ padding: '1rem', border: '1px solid #dc2626' }}>Student Name</th>
                  <th style={{ padding: '1rem', border: '1px solid #dc2626' }}>Rejection Reason / Remark</th>
                  <th style={{ padding: '1rem', border: '1px solid #dc2626' }}>Status</th>
                </tr>
              </thead>
              <tbody>
                {rejectedApplications.length === 0 ? (
                  <tr>
                    <td colSpan="4" style={{ padding: '2rem', textAlign: 'center', color: '#64748b' }}>
                      No rejected applications found in database.
                    </td>
                  </tr>
                ) : (
                  rejectedApplications.map((r, idx) => (
                    <tr key={r.id || idx} style={{ textAlign: 'center', borderBottom: '1px solid #e2e8f0' }}>
                      <td style={{ padding: '1rem', border: '1px solid #e2e8f0' }}>{r.prnno}</td>
                      <td style={{ padding: '1rem', border: '1px solid #e2e8f0', fontWeight: 'bold' }}>{r.studentName}</td>
                      <td style={{ padding: '1rem', border: '1px solid #e2e8f0', color: '#b91c1c', fontWeight: '600' }}>{r.rejectionRemark}</td>
                      <td style={{ padding: '1rem', border: '1px solid #e2e8f0' }}>
                        <span style={{ background: '#fee2e2', color: '#991b1b', padding: '0.2rem 0.6rem', borderRadius: '4px', fontWeight: 'bold' }}>
                          Rejected
                        </span>
                      </td>
                    </tr>
                  ))
                )}
              </tbody>
            </table>
          </div>
        )}

        {/* VIEW 2-C: BONAFIDE REQUESTS LIST */}
        {currentView === 'BONAFIDE_LIST' && (
          <div style={{ background: '#ffffff', borderRadius: '12px', padding: '2rem', boxShadow: '0 4px 16px rgba(0,0,0,0.06)', border: '1px solid #e2e8f0' }}>
            <button onClick={() => setCurrentView('HOME')} style={{ padding: '0.4rem 1rem', background: '#ffffff', border: '1px solid #000000', borderRadius: '6px', cursor: 'pointer', fontWeight: '600', marginBottom: '1.5rem' }}>
              ← Back to Dashboard
            </button>
            <h2 style={{ textAlign: 'center', fontSize: '1.6rem', fontWeight: '800', marginBottom: '1.5rem', textTransform: 'uppercase' }}>
              BONAFIDE CERTIFICATE REQUESTS
            </h2>
            <table style={{ width: '100%', borderCollapse: 'collapse' }}>
              <thead>
                <tr style={{ background: '#22c55e', color: '#ffffff', textAlign: 'center' }}>
                  <th style={{ padding: '1rem' }}>Req ID</th>
                  <th style={{ padding: '1rem' }}>PRN Number</th>
                  <th style={{ padding: '1rem' }}>Reason</th>
                  <th style={{ padding: '1rem' }}>Status</th>
                  <th style={{ padding: '1rem' }}>Action</th>
                </tr>
              </thead>
              <tbody>
                {pendingBonafides.map(b => (
                  <tr key={b.id} style={{ textAlign: 'center', borderBottom: '1px solid #e2e8f0' }}>
                    <td style={{ padding: '1rem' }}>#{b.id}</td>
                    <td style={{ padding: '1rem', fontWeight: 'bold' }}>{b.prnno}</td>
                    <td style={{ padding: '1rem' }}>{b.reason}</td>
                    <td style={{ padding: '1rem' }}><span style={{ background: '#fef08a', color: '#854d0e', padding: '0.2rem 0.6rem', borderRadius: '4px' }}>{b.status}</span></td>
                    <td style={{ padding: '1rem' }}>
                      <button onClick={async () => {
                        await fetch(`${API_BASE}/api/v1/bonafide/approve/${b.id}`, { method: 'POST' });
                        setActionMessage(`Bonafide Request #${b.id} approved!`);
                        fetchPendingRequests(currentDeskNo);
                      }} style={{ background: '#22c55e', color: 'white', border: 'none', padding: '0.4rem 1rem', borderRadius: '6px', cursor: 'pointer', fontWeight: 'bold' }}>
                        Approve
                      </button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        )}

        {/* VIEW 3: STUDENT ACADEMIC VERIFICATION DETAIL SCREEN (stud_sect_action.php) */}
        {currentView === 'VERIFICATION_VIEW' && selectedStudent && (
          <div style={{ background: '#ffffff', borderRadius: '12px', padding: '2.5rem', boxShadow: '0 4px 20px rgba(0,0,0,0.08)', border: '1px solid #e2e8f0' }}>
            
            <button 
              onClick={() => setCurrentView('LC_LIST')} 
              style={{ padding: '0.4rem 1rem', background: '#ffffff', border: '1px solid #000000', borderRadius: '6px', cursor: 'pointer', fontWeight: '600', marginBottom: '1.5rem' }}
            >
              ← Back to Requests List
            </button>

            <h2 style={{ textAlign: 'center', fontSize: '1.6rem', fontWeight: '800', margin: '0 0 1rem 0' }}>
              PRN Number: {selectedStudent.prnno}
            </h2>

            <h3 style={{ textAlign: 'center', fontSize: '1.4rem', fontWeight: '800', margin: '0 0 2rem 0', color: '#1e293b' }}>
              NAME: {selectedStudent.studentName}
            </h3>

            {/* Academic Verification Table */}
            <table style={{ width: '100%', borderCollapse: 'collapse', marginBottom: '2.5rem' }}>
              <thead>
                <tr style={{ background: '#41b35d', color: '#ffffff', textAlign: 'left', fontSize: '1rem' }}>
                  <th style={{ padding: '0.85rem 1.25rem', border: '1px solid #389e52' }}>Year</th>
                  <th style={{ padding: '0.85rem 1.25rem', border: '1px solid #389e52' }}>Academic Status</th>
                  <th style={{ padding: '0.85rem 1.25rem', border: '1px solid #389e52' }}>SGPA</th>
                  <th style={{ padding: '0.85rem 1.25rem', border: '1px solid #389e52' }}>CGPA</th>
                  <th style={{ padding: '0.85rem 1.25rem', border: '1px solid #389e52' }}>Exam Form Status</th>
                </tr>
              </thead>
              <tbody>
                {(selectedStudent.academicHistory || []).map((row, idx) => (
                  <tr key={idx} style={{ background: idx % 2 === 1 ? '#f8fafc' : '#ffffff', fontSize: '0.95rem' }}>
                    <td style={{ padding: '0.85rem 1.25rem', border: '1px solid #e2e8f0' }}>{row.year}</td>
                    <td style={{ padding: '0.85rem 1.25rem', border: '1px solid #e2e8f0' }}>{row.status}</td>
                    <td style={{ padding: '0.85rem 1.25rem', border: '1px solid #e2e8f0' }}>{row.sgpa}</td>
                    <td style={{ padding: '0.85rem 1.25rem', border: '1px solid #e2e8f0' }}>{row.cgpa}</td>
                    <td style={{ padding: '0.85rem 1.25rem', border: '1px solid #e2e8f0' }}>{row.examStatus}</td>
                  </tr>
                ))}
              </tbody>
            </table>

            {/* 3 Action Buttons */}
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', maxWidth: '800px', margin: '0 auto' }}>
              
              {/* Green Approve Button */}
              <button 
                onClick={() => handleApproveLcSection(selectedStudent.id)}
                style={{ background: '#41b35d', color: '#ffffff', border: 'none', padding: '0.75rem 2.5rem', borderRadius: '8px', fontWeight: '700', fontSize: '1.1rem', cursor: 'pointer' }}
              >
                Approve
              </button>

              {/* Red Reject Button */}
              <button 
                onClick={() => setShowRejectModal(true)}
                style={{ background: '#ef4444', color: '#ffffff', border: 'none', padding: '0.75rem 2.5rem', borderRadius: '8px', fontWeight: '700', fontSize: '1.1rem', cursor: 'pointer' }}
              >
                Reject
              </button>

              {/* Red Failed Button */}
              <button 
                onClick={() => setShowFailedModal(true)}
                style={{ background: '#ef4444', color: '#ffffff', border: 'none', padding: '0.75rem 2.5rem', borderRadius: '8px', fontWeight: '700', fontSize: '1.1rem', cursor: 'pointer' }}
              >
                Failed
              </button>

            </div>

          </div>
        )}

      </main>

      {/* REJECT MODAL POPUP */}
      {showRejectModal && (
        <div style={{ position: 'fixed', top: 0, left: 0, right: 0, bottom: 0, background: 'rgba(0,0,0,0.5)', display: 'flex', alignItems: 'center', justifyContent: 'center', zIndex: 1000 }}>
          <div style={{ background: '#ffffff', width: '450px', padding: '2rem', borderRadius: '12px', boxShadow: '0 10px 25px rgba(0,0,0,0.2)' }}>
            <h3 style={{ marginTop: 0, marginBottom: '1rem', color: '#0f172a' }}>Reason for Rejection</h3>
            <form onSubmit={handleRejectSubmit}>
              <input 
                type="text" 
                placeholder="Enter the reason for rejection" 
                value={rejectionReason}
                onChange={e => setRejectionReason(e.target.value)}
                style={{ width: '100%', padding: '0.75rem', border: '1px solid #cbd5e1', borderRadius: '6px', marginBottom: '1.5rem', fontSize: '1rem' }}
                required
              />
              <div style={{ display: 'flex', justifyContent: 'flex-end', gap: '1rem' }}>
                <button type="button" onClick={() => setShowRejectModal(false)} style={{ padding: '0.6rem 1.25rem', background: '#cbd5e1', border: 'none', borderRadius: '6px', cursor: 'pointer', fontWeight: '600' }}>
                  Cancel
                </button>
                <button type="submit" style={{ padding: '0.6rem 1.25rem', background: '#ef4444', color: 'white', border: 'none', borderRadius: '6px', cursor: 'pointer', fontWeight: '600' }}>
                  Submit
                </button>
              </div>
            </form>
          </div>
        </div>
      )}

      {/* FAILED MODAL POPUP */}
      {showFailedModal && (
        <div style={{ position: 'fixed', top: 0, left: 0, right: 0, bottom: 0, background: 'rgba(0,0,0,0.5)', display: 'flex', alignItems: 'center', justifyContent: 'center', zIndex: 1000 }}>
          <div style={{ background: '#ffffff', width: '450px', padding: '2rem', borderRadius: '12px', boxShadow: '0 10px 25px rgba(0,0,0,0.2)' }}>
            <h3 style={{ marginTop: 0, marginBottom: '1rem', color: '#0f172a' }}>Enter Failed Value</h3>
            <form onSubmit={handleFailedSubmit}>
              <input 
                type="text" 
                placeholder="Enter the Failed value" 
                value={failedValue}
                onChange={e => setFailedValue(e.target.value)}
                style={{ width: '100%', padding: '0.75rem', border: '1px solid #cbd5e1', borderRadius: '6px', marginBottom: '1.5rem', fontSize: '1rem' }}
                required
              />
              <div style={{ display: 'flex', justifyContent: 'flex-end', gap: '1rem' }}>
                <button type="button" onClick={() => setShowFailedModal(false)} style={{ padding: '0.6rem 1.25rem', background: '#cbd5e1', border: 'none', borderRadius: '6px', cursor: 'pointer', fontWeight: '600' }}>
                  Cancel
                </button>
                <button type="submit" style={{ padding: '0.6rem 1.25rem', background: '#ef4444', color: 'white', border: 'none', borderRadius: '6px', cursor: 'pointer', fontWeight: '600' }}>
                  Submit
                </button>
              </div>
            </form>
          </div>
        </div>
      )}

    </div>
  );
}
