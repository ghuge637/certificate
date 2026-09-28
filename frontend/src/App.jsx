import React, { useState } from 'react';
import Login from './components/Login';
import StudentDashboard from './components/StudentDashboard';
import StaffDashboard from './components/StaffDashboard';

export default function App() {
  const [currentUser, setCurrentUser] = useState(null);

  if (!currentUser) {
    return <Login onLoginSuccess={(user) => setCurrentUser(user)} />;
  }

  if (currentUser.role === 'STUDENT') {
    return <StudentDashboard user={currentUser} onLogout={() => setCurrentUser(null)} />;
  }

  return <StaffDashboard user={currentUser} onLogout={() => setCurrentUser(null)} />;
}
