@extends('new')

@section('page_title', 'EMIS Settings')
@section('page_description', 'Centralized EMIS administration panel for professional system configuration, workflow controls, security and maintenance.')

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.settings-nav a').forEach(function (link) {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                var section = document.querySelector(this.getAttribute('href'));
                if (section) section.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    });
</script>
@endpush
@section('content')
<style>
    .settings-shell {
        display: grid;
        grid-template-columns: 280px minmax(0, 1fr);
        gap: 18px;
    }

    .settings-sidebar,
    .settings-panel,
    .settings-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
    }

    .settings-sidebar {
        padding: 18px;
        position: sticky;
        top: 72px;
        height: fit-content;
    }

    .settings-brand {
        padding: 16px;
        border-radius: 16px;
        background: linear-gradient(135deg, #0b3563, #174f8a);
        color: #fff;
        margin-bottom: 16px;
    }

    .settings-brand h3 {
        font-size: 18px;
        margin: 0 0 6px;
    }

    .settings-brand p {
        margin: 0;
        opacity: .85;
        font-size: 12px;
    }

    .settings-nav {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .settings-nav a {
        color: #1e293b;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 13px;
        font-weight: 600;
    }

    .settings-nav a:hover {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #0b3563;
    }

    .settings-content {
        display: grid;
        gap: 18px;
    }

    .settings-panel {
        padding: 22px;
    }

    .settings-hero {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        align-items: flex-start;
        flex-wrap: wrap;
    }

    .settings-hero h1 {
        font-size: 24px;
        margin: 0 0 6px;
    }

    .settings-hero p {
        color: #64748b;
        margin: 0;
        max-width: 720px;
    }

    .settings-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .settings-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .settings-card {
        padding: 20px;
    }

    .settings-card h3 {
        font-size: 17px;
        margin: 0 0 6px;
    }

    .settings-card p.section-copy {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 16px;
    }

    .settings-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .settings-form-grid.full {
        grid-template-columns: 1fr;
    }

    .settings-field label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }

    .settings-field input,
    .settings-field select,
    .settings-field textarea {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 11px 12px;
        font-size: 13px;
        background: #fff;
    }

    .settings-field textarea {
        min-height: 96px;
        resize: vertical;
    }

    .settings-switch {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        padding: 12px 0;
        border-top: 1px solid #eef2f7;
    }

    .settings-switch:first-of-type {
        border-top: 0;
        padding-top: 0;
    }

    .settings-switch h4 {
        font-size: 14px;
        margin: 0 0 4px;
    }

    .settings-switch p {
        margin: 0;
        font-size: 12px;
        color: #64748b;
    }

    .settings-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
        margin-top: 18px;
    }

    .stat-chip {
        border-radius: 16px;
        padding: 14px 16px;
        background: linear-gradient(180deg, #f8fafc, #eef2f7);
        border: 1px solid #e2e8f0;
    }

    .stat-chip span {
        display: block;
        color: #64748b;
        font-size: 12px;
    }

    .stat-chip strong {
        display: block;
        margin-top: 6px;
        font-size: 18px;
        color: #0f172a;
    }

    .check-row {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        margin-bottom: 10px;
    }

    .settings-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 6px;
        flex-wrap: wrap;
    }

    @media (max-width: 1100px) {
        .settings-shell,
        .settings-grid,
        .settings-form-grid,
        .settings-stats {
            grid-template-columns: 1fr;
        }

        .settings-sidebar {
            position: static;
        }
    }
</style>

<div class="settings-shell">
    <aside class="settings-sidebar">
        <div class="settings-brand">
            <h3>EMIS Settings Center</h3>
            <p>Configure system behavior, document workflow, security, localization, reporting, and maintenance from one place.</p>
        </div>

        <nav class="settings-nav">
            <a href="#general">General</a>
            <a href="#organization">Organization</a>
            <a href="#localization">Localization</a>
            <a href="#security">Security</a>
            <a href="#notifications">Notifications</a>
            <a href="#correspondence">Correspondence</a>
            <a href="#workflow">Workflow</a>
            <a href="#reports">Reports & Backup</a>
            <a href="#maintenance">Maintenance</a>
            <a href="#about">About System</a>
        </nav>
    </aside>

    <div class="settings-content">
        <section class="settings-panel" id="general">
            <div class="settings-hero">
                <div>
                    <h1>EMIS Administration Settings</h1>
                    <p>Use this page to manage core Education Management Information System preferences, office identity, user experience defaults, approvals, monitoring, data governance, and continuity controls.</p>
                </div>

                <div class="settings-actions">
                    <button class="btn btn-outline-primary">Preview Changes</button>
                    <button class="btn btn-success">Save Settings</button>
                </div>
            </div>

            <div class="settings-stats">
                <div class="stat-chip">
                    <span>Default locale</span>
                    <strong>{{ app()->getLocale() }}</strong>
                </div>
                <div class="stat-chip">
                    <span>Timezone</span>
                    <strong>Asia/Kabul</strong>
                </div>
                <div class="stat-chip">
                    <span>Environment</span>
                    <strong>{{ app()->environment() }}</strong>
                </div>
                <div class="stat-chip">
                    <span>Current admin</span>
                    <strong>{{ auth()->user()->name ?? 'System Admin' }}</strong>
                </div>
            </div>
        </section>

        <div class="settings-grid">
            <section class="settings-card" id="organization">
                <h3>Organization Profile</h3>
                <p class="section-copy">Define the identity and operating defaults of your EMIS deployment.</p>

                <div class="settings-form-grid">
                    <div class="settings-field">
                        <label>System Name</label>
                        <input type="text" value="Education Management Information System">
                    </div>
                    <div class="settings-field">
                        <label>Short Name</label>
                        <input type="text" value="EMIS">
                    </div>
                    <div class="settings-field">
                        <label>Institution / Department</label>
                        <input type="text" value="Directorate General of Budget">
                    </div>
                    <div class="settings-field">
                        <label>Academic / Fiscal Year</label>
                        <select>
                            <option selected>2026 - 2027</option>
                            <option>2025 - 2026</option>
                            <option>2024 - 2025</option>
                        </select>
                    </div>
                    <div class="settings-field">
                        <label>Support Email</label>
                        <input type="email" value="support@emis.local">
                    </div>
                    <div class="settings-field">
                        <label>Support Phone</label>
                        <input type="text" value="+93 700 000 000">
                    </div>
                </div>
            </section>

            <section class="settings-card" id="localization">
                <h3>Localization & Regional Format</h3>
                <p class="section-copy">Choose how users see language, time, numbers, and document labels.</p>

                <div class="settings-form-grid">
                    <div class="settings-field">
                        <label>Default Language</label>
                        <select>
                            <option {{ app()->getLocale() === 'en' ? 'selected' : '' }}>English</option>
                            <option {{ app()->getLocale() === 'ps' ? 'selected' : '' }}>Pashto</option>
                            <option {{ app()->getLocale() === 'fa' ? 'selected' : '' }}>Dari</option>
                        </select>
                    </div>
                    <div class="settings-field">
                        <label>Timezone</label>
                        <select>
                            <option selected>Asia/Kabul</option>
                        </select>
                    </div>
                    <div class="settings-field">
                        <label>Date Format</label>
                        <select>
                            <option selected>Y-m-d</option>
                            <option>d/m/Y</option>
                            <option>m/d/Y</option>
                        </select>
                    </div>
                    <div class="settings-field">
                        <label>Number Format</label>
                        <select>
                            <option selected>1,234.56</option>
                            <option>1.234,56</option>
                        </select>
                    </div>
                    <div class="settings-field">
                        <label>Currency</label>
                        <select>
                            <option selected>AFN - Afghani</option>
                            <option>USD - US Dollar</option>
                        </select>
                    </div>
                    <div class="settings-field">
                        <label>Direction Mode</label>
                        <select>
                            <option selected>Auto by locale</option>
                            <option>Force RTL</option>
                            <option>Force LTR</option>
                        </select>
                    </div>
                </div>
            </section>

            <section class="settings-card" id="security">
                <h3>Security & Access Control</h3>
                <p class="section-copy">Control authentication, session behavior, and user protection.</p>

                <div class="settings-switch">
                    <div>
                        <h4>Enable two-factor authentication</h4>
                        <p>Require a second verification step for privileged users.</p>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" checked>
                    </div>
                </div>

                <div class="settings-switch">
                    <div>
                        <h4>Auto logout inactive users</h4>
                        <p>Protect shared-office sessions from unauthorized access.</p>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" checked>
                    </div>
                </div>

                <div class="settings-form-grid">
                    <div class="settings-field">
                        <label>Max login attempts</label>
                        <input type="number" value="5">
                    </div>
                    <div class="settings-field">
                        <label>Session timeout (minutes)</label>
                        <input type="number" value="30">
                    </div>
                    <div class="settings-field">
                        <label>Password minimum length</label>
                        <input type="number" value="8">
                    </div>
                    <div class="settings-field">
                        <label>Password expiry (days)</label>
                        <input type="number" value="90">
                    </div>
                </div>
            </section>

            <section class="settings-card" id="notifications">
                <h3>Notifications & Reminders</h3>
                <p class="section-copy">Decide what the system should tell users and when.</p>

                <label class="check-row"><input type="checkbox" checked> Email alerts for incoming correspondence</label>
                <label class="check-row"><input type="checkbox" checked> Task deadline reminders</label>
                <label class="check-row"><input type="checkbox" checked> Approval pending alerts</label>
                <label class="check-row"><input type="checkbox"> SMS escalation for urgent items</label>
                <label class="check-row"><input type="checkbox"> Daily executive digest</label>
            </section>

            <section class="settings-card" id="correspondence">
                <h3>Correspondence Management</h3>
                <p class="section-copy">Set numbering rules, document handling, and file intake preferences.</p>

                <div class="settings-form-grid">
                    <div class="settings-field">
                        <label>Incoming document prefix</label>
                        <input type="text" value="IN-EMIS">
                    </div>
                    <div class="settings-field">
                        <label>Outgoing document prefix</label>
                        <input type="text" value="OUT-EMIS">
                    </div>
                    <div class="settings-field">
                        <label>Reference sequence start</label>
                        <input type="number" value="1001">
                    </div>
                    <div class="settings-field">
                        <label>Maximum upload size (MB)</label>
                        <input type="number" value="10">
                    </div>
                </div>

                <label class="check-row"><input type="checkbox" checked> Require subject for all correspondence</label>
                <label class="check-row"><input type="checkbox" checked> Require receiver/sender metadata</label>
                <label class="check-row"><input type="checkbox" checked> Allow file attachments on inbox and outbox</label>
            </section>

            <section class="settings-card" id="workflow">
                <h3>Workflow, Approval & Roles</h3>
                <p class="section-copy">Set how requests move through the organization and who can approve them.</p>

                <div class="settings-form-grid">
                    <div class="settings-field">
                        <label>Default approval model</label>
                        <select>
                            <option selected>Sequential</option>
                            <option>Parallel</option>
                            <option>Role-based automatic</option>
                        </select>
                    </div>
                    <div class="settings-field">
                        <label>Approval escalation after (hours)</label>
                        <input type="number" value="24">
                    </div>
                    <div class="settings-field">
                        <label>Task default priority</label>
                        <select>
                            <option>Low</option>
                            <option selected>Medium</option>
                            <option>High</option>
                        </select>
                    </div>
                    <div class="settings-field">
                        <label>Default assignee group</label>
                        <input type="text" value="Operations Office">
                    </div>
                </div>

                <label class="check-row"><input type="checkbox" checked> Keep audit trail for approvals</label>
                <label class="check-row"><input type="checkbox" checked> Lock completed approvals from editing</label>
                <label class="check-row"><input type="checkbox"> Allow delegation during leave periods</label>
            </section>

            <section class="settings-card" id="reports">
                <h3>Reports, Backup & Data Retention</h3>
                <p class="section-copy">Manage scheduled exports, backups, archival windows, and audit retention.</p>

                <div class="settings-form-grid">
                    <div class="settings-field">
                        <label>Automatic backup schedule</label>
                        <select>
                            <option>Every 6 hours</option>
                            <option selected>Daily</option>
                            <option>Weekly</option>
                        </select>
                    </div>
                    <div class="settings-field">
                        <label>Retention period (days)</label>
                        <input type="number" value="365">
                    </div>
                    <div class="settings-field">
                        <label>Default report format</label>
                        <select>
                            <option>PDF</option>
                            <option selected>Excel</option>
                            <option>CSV</option>
                        </select>
                    </div>
                    <div class="settings-field">
                        <label>Archive completed tasks after (days)</label>
                        <input type="number" value="180">
                    </div>
                </div>

                <div class="settings-actions mt-3">
                    <button class="btn btn-outline-primary">Run Backup Now</button>
                    <button class="btn btn-outline-secondary">Download Audit Log</button>
                </div>
            </section>

            <section class="settings-card" id="maintenance">
                <h3>Maintenance & Technical Controls</h3>
                <p class="section-copy">Handle operational settings for safe upgrades and troubleshooting.</p>

                <label class="check-row"><input type="checkbox"> Enable maintenance mode</label>
                <label class="check-row"><input type="checkbox" checked> Show system health indicators on dashboard</label>
                <label class="check-row"><input type="checkbox" checked> Enable debug logging for failures</label>
                <label class="check-row"><input type="checkbox"> Restrict access by office IP range</label>

                <div class="settings-form-grid full">
                    <div class="settings-field">
                        <label>Maintenance notice</label>
                        <textarea>EMIS may be temporarily unavailable during scheduled maintenance or system upgrades.</textarea>
                    </div>
                </div>
            </section>
        </div>

        <section class="settings-card" id="about">
            <h3>About This EMIS Deployment</h3>
            <p class="section-copy">Reference details for the installed instance and support ownership.</p>

            <div class="settings-form-grid">
                <div class="settings-field">
                    <label>Version</label>
                    <input type="text" value="EMIS v1.0.0" readonly>
                </div>
                <div class="settings-field">
                    <label>Deployment environment</label>
                    <input type="text" value="{{ app()->environment() }}" readonly>
                </div>
                <div class="settings-field">
                    <label>Primary support contact</label>
                    <input type="text" value="EMIS Technical Team" readonly>
                </div>
                <div class="settings-field">
                    <label>Support channel</label>
                    <input type="text" value="support@emis.local" readonly>
                </div>
            </div>

            <div class="settings-footer">
                <button class="btn btn-outline-secondary">Cancel</button>
                <button class="btn btn-success">Save All Changes</button>
            </div>
        </section>
    </div>
</div>
@endsection
