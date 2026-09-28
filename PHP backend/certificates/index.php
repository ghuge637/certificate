<?php
session_start();
include 'db_conn.php';

$errorMessage = '';
$selectedRole = '';
$enteredUsername = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedRole = trim($_POST['role'] ?? '');
    $enteredUsername = trim($_POST['username'] ?? '');
    $enteredPassword = $_POST['password'] ?? '';

    if ($selectedRole === 'student') {
        $statement = mysqli_prepare($conn, 'SELECT prnno, studdob FROM students WHERE prnno = ? LIMIT 1');

        if ($statement) {
            mysqli_stmt_bind_param($statement, 's', $enteredUsername);
            mysqli_stmt_execute($statement);
            mysqli_stmt_bind_result($statement, $studentId, $studentDob);

            if (mysqli_stmt_fetch($statement)) {
                if ($enteredPassword === $studentDob) {
                    $_SESSION['stud_id'] = $studentId;
                    mysqli_stmt_close($statement);
                    header('Location: user_page.php');
                    exit;
                }

                $errorMessage = 'Incorrect password.';
            } else {
                $errorMessage = 'Incorrect username.';
            }

            mysqli_stmt_close($statement);
        } else {
            $errorMessage = 'Unable to complete login right now.';
        }
    } elseif ($selectedRole === 'staff') {
        $statement = mysqli_prepare($conn, 'SELECT user_id, password, desk_no FROM desks WHERE user_id = ? LIMIT 1');

        if ($statement) {
            mysqli_stmt_bind_param($statement, 's', $enteredUsername);
            mysqli_stmt_execute($statement);
            mysqli_stmt_bind_result($statement, $staffUserId, $staffPassword, $deskNumber);

            if (mysqli_stmt_fetch($statement)) {
                if ($enteredPassword === $staffPassword) {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $staffUserId;
                    $_SESSION['role'] = $selectedRole;
                    $_SESSION['desk_no'] = $deskNumber;

                    mysqli_stmt_close($statement);

                    switch ((int) $deskNumber) {
                        case 1:
                            header('Location: sections/student_section.php');
                            exit;

                        case 2:
                            header('Location: sections/scholarship_section.php');
                            exit;

                        default:
                            header('Location: leaving_certificate/noDue/multi_section_actions.php');
                            exit;
                    }
                }

                $errorMessage = 'Incorrect password.';
            } else {
                $errorMessage = 'Incorrect username.';
            }

            mysqli_stmt_close($statement);
        } else {
            $errorMessage = 'Unable to complete login right now.';
        }
    } else {
        $errorMessage = 'Please select a valid role.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate System | Sign In</title>
    <style>
        :root {
            --page-bg-start: #ece0cf;
            --page-bg-mid: #f7f3eb;
            --page-bg-end: #ece6dc;
            --card-bg: #ffffff;
            --card-border: rgba(26, 53, 104, 0.08);
            --card-shadow: rgba(44, 61, 89, 0.18);
            --brand-start: #173f82;
            --brand-end: #2a5fb4;
            --brand-pill-border: rgba(255, 255, 255, 0.38);
            --brand-text-soft: rgba(255, 255, 255, 0.94);
            --text-main: #071225;
            --text-muted: #5f7396;
            --field-border: #cdd8ea;
            --field-focus: #3668be;
            --field-placeholder: #7d8ba5;
            --button-start: #2d63bc;
            --button-end: #204f99;
            --button-shadow: rgba(33, 81, 158, 0.28);
            --error-bg: #fff2f2;
            --error-border: #efc0c0;
            --error-text: #9f2d2d;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100dvh;
            font-family: "Trebuchet MS", "Segoe UI", sans-serif;
            color: var(--text-main);
            background: radial-gradient(circle at top left, var(--page-bg-start) 0, var(--page-bg-mid) 32%, var(--page-bg-end) 100%);
        }

        .page-shell {
            --shell-pad-y: clamp(16px, 3vh, 34px);
            --shell-pad-x: clamp(16px, 2vw, 24px);
            min-height: 100dvh;
            display: grid;
            place-items: center;
            padding: var(--shell-pad-y) var(--shell-pad-x);
        }

        .signin-card {
            width: min(1410px, 100%);
            height: min(780px, calc(100dvh - (var(--shell-pad-y) * 2)));
            min-height: 0;
            display: grid;
            grid-template-columns: minmax(370px, 48%) 1fr;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 26px 70px var(--card-shadow);
        }

        .brand-panel {
            min-height: 100%;
            display: flex;
            flex-direction: column;
            padding: clamp(28px, 5vh, 50px) clamp(24px, 3vw, 42px) clamp(24px, 4.5vh, 48px);
            background: linear-gradient(180deg, var(--brand-start) 0%, var(--brand-end) 100%);
            color: #ffffff;
        }

        .brand-pill {
            width: fit-content;
            padding: 12px 18px;
            border: 1px solid var(--brand-pill-border);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.05);
            font-size: 0.9rem;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .brand-copy {
            margin-top: clamp(18px, 3.2vh, 34px);
            max-width: 520px;
        }

        .brand-copy h1 {
            margin: 0;
            font-size: clamp(3rem, 4vw, 4.5rem);
            line-height: 1.03;
            letter-spacing: -0.04em;
        }

        .brand-copy p {
            margin: 22px 0 0;
            max-width: 470px;
            font-size: clamp(1.2rem, 1.8vw, 1.85rem);
            line-height: 1.35;
            color: var(--brand-text-soft);
        }

        .brand-footnote {
            margin-top: auto;
            font-size: 1.1rem;
            line-height: 1.4;
            color: rgba(255, 255, 255, 0.97);
        }

        .form-panel {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding: clamp(30px, 5vh, 54px) clamp(24px, 3vw, 42px) clamp(24px, 4.5vh, 48px);
            background: #ffffff;
        }

        .form-copy h2 {
            margin: 0;
            font-size: clamp(2.35rem, 3vw, 3.4rem);
            line-height: 1.05;
            letter-spacing: -0.03em;
        }

        .form-copy p {
            margin: 14px 0 0;
            font-size: 1.15rem;
            line-height: 1.5;
            color: var(--text-muted);
        }

        .status-message {
            margin-top: clamp(16px, 2.4vh, 24px);
            padding: 14px 16px;
            border: 1px solid var(--error-border);
            border-radius: 14px;
            background: var(--error-bg);
            color: var(--error-text);
            font-size: 0.98rem;
            line-height: 1.45;
        }

        .form-grid {
            margin-top: clamp(20px, 3.5vh, 30px);
            display: grid;
            gap: clamp(14px, 2.2vh, 20px);
        }

        .field-group {
            display: grid;
            gap: 10px;
        }

        .field-group label {
            font-size: 1.05rem;
            font-weight: 700;
            color: #101828;
        }

        .field-control {
            width: 100%;
            height: clamp(54px, 7vh, 64px);
            padding: 0 18px;
            border: 1.5px solid var(--field-border);
            border-radius: 18px;
            background: #ffffff;
            color: var(--text-main);
            font: inherit;
            font-size: 1.1rem;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }

        select.field-control {
            appearance: none;
            padding-right: 56px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='none' stroke='%2332446f' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M5 7.5L10 12.5L15 7.5'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 18px center;
            background-size: 18px;
        }

        .field-control::placeholder {
            color: var(--field-placeholder);
        }

        .field-control:focus {
            border-color: var(--field-focus);
            box-shadow: 0 0 0 4px rgba(54, 104, 190, 0.12);
        }

        .primary-button {
            width: 100%;
            height: clamp(56px, 7vh, 66px);
            border: none;
            border-radius: 16px;
            background: linear-gradient(180deg, var(--button-start) 0%, var(--button-end) 100%);
            color: #ffffff;
            font: inherit;
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: 0.01em;
            cursor: pointer;
            box-shadow: 0 16px 26px -18px var(--button-shadow);
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
        }

        .primary-button:hover {
            transform: translateY(-1px);
            filter: brightness(1.03);
            box-shadow: 0 18px 28px -18px var(--button-shadow);
        }

        .primary-button:focus-visible {
            outline: 3px solid rgba(54, 104, 190, 0.2);
            outline-offset: 3px;
        }

        .helper-text {
            margin: clamp(12px, 2.2vh, 22px) 0 0;
            text-align: center;
            font-size: 1.02rem;
            line-height: 1.45;
            color: var(--text-muted);
        }

        @media (min-width: 961px) {
            body {
                overflow: hidden;
            }
        }

        @media (max-width: 1366px) and (min-width: 961px) {
            .signin-card {
                grid-template-columns: minmax(330px, 46%) 1fr;
            }

            .brand-copy h1 {
                font-size: clamp(2.7rem, 3.4vw, 3.9rem);
            }

            .brand-copy p {
                max-width: 420px;
                font-size: clamp(1.05rem, 1.35vw, 1.4rem);
            }

            .form-copy h2 {
                font-size: clamp(2rem, 2.5vw, 2.85rem);
            }
        }

        @media (max-height: 820px) and (min-width: 961px) {
            .brand-pill {
                padding: 10px 16px;
                font-size: 0.82rem;
            }

            .brand-footnote {
                font-size: 1rem;
            }

            .field-group label {
                font-size: 1rem;
            }

            .helper-text {
                font-size: 0.95rem;
            }
        }

        @media (prefers-reduced-motion: no-preference) {
            .signin-card {
                animation: card-rise 0.55s ease both;
            }

            @keyframes card-rise {
                from {
                    opacity: 0;
                    transform: translateY(22px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        }

        @media (max-width: 960px) {
            .page-shell {
                padding: 28px 14px 32px;
            }

            .signin-card {
                height: auto;
                min-height: 0;
                grid-template-columns: 1fr;
                border-radius: 22px;
            }

            .brand-panel {
                min-height: 0;
                padding: 20px 16px 18px;
            }

            .brand-pill {
                padding: 7px 12px;
                font-size: 0.63rem;
            }

            .brand-copy {
                margin-top: 16px;
                max-width: 100%;
            }

            .brand-copy h1 {
                font-size: 2.35rem;
                line-height: 1.08;
            }

            .brand-copy p {
                margin-top: 12px;
                font-size: 0.98rem;
                line-height: 1.45;
            }

            .brand-footnote {
                margin-top: 14px;
                font-size: 0.95rem;
            }

            .form-panel {
                padding: 18px 16px 22px;
            }

            .form-copy h2 {
                font-size: 2.05rem;
            }

            .form-copy p {
                margin-top: 8px;
                font-size: 1rem;
            }

            .status-message {
                margin-top: 18px;
                padding: 12px 14px;
                font-size: 0.92rem;
            }

            .form-grid {
                margin-top: 18px;
                gap: 16px;
            }

            .field-group {
                gap: 8px;
            }

            .field-group label {
                font-size: 0.98rem;
            }

            .field-control {
                height: 48px;
                border-radius: 10px;
                font-size: 0.98rem;
            }

            .primary-button {
                height: 48px;
                border-radius: 8px;
                font-size: 1rem;
            }

            .helper-text {
                margin-top: 10px;
                font-size: 0.83rem;
            }
        }
    </style>
</head>
<body>
    <div class="page-shell">
        <main class="signin-card">
            <section class="brand-panel">
                <div class="brand-pill">Certificate System</div>

                <div class="brand-copy">
                    <h1>Keystone School of Engineering</h1>
                    <p>Centralized portal for Bonafide and Leaving Certificate workflows.</p>
                </div>

                <p class="brand-footnote">Secure login for students and staff.</p>
            </section>

            <section class="form-panel">
                <div class="form-copy">
                    <h2>Sign In</h2>
                    <p>Use your assigned credentials to continue.</p>
                </div>

                <?php if ($errorMessage !== ''): ?>
                    <div class="status-message" role="alert"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>

                <form action="" method="POST" class="form-grid">
                    <div class="field-group">
                        <label for="role">Role</label>
                        <select name="role" id="role" class="field-control" required>
                            <option value="" <?php echo $selectedRole === '' ? 'selected' : ''; ?> disabled>Select role</option>
                            <option value="student" <?php echo $selectedRole === 'student' ? 'selected' : ''; ?>>Student</option>
                            <option value="staff" <?php echo $selectedRole === 'staff' ? 'selected' : ''; ?>>Staff</option>
                        </select>
                    </div>

                    <div class="field-group">
                        <label for="username">Username</label>
                        <input
                            type="text"
                            name="username"
                            id="username"
                            class="field-control"
                            placeholder="Enter username"
                            value="<?php echo htmlspecialchars($enteredUsername, ENT_QUOTES, 'UTF-8'); ?>"
                            autocomplete="username"
                            required
                        >
                    </div>

                    <div class="field-group">
                        <label for="password">Password</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="field-control"
                            placeholder="Enter password"
                            autocomplete="current-password"
                            required
                        >
                    </div>

                    <button type="submit" name="login" class="primary-button">Login</button>
                </form>

                <p class="helper-text">For access issues, contact the section administrator.</p>
            </section>
        </main>
    </div>
</body>
</html>
