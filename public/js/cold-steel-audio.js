/**
 * Trails of Cold Steel / ARCUS Sound Effects for Web
 */

// Load audio dari direktori /audio/
const sfxHover   = new Audio('/audio/hover.wav');
const sfxDecide  = new Audio('/audio/decide.wav');
const sfxDecline = new Audio('/audio/decline.wav');
const sfxBack    = new Audio('/audio/back.wav');

// Pengaturan volume
sfxHover.volume   = 0.35;
sfxDecide.volume  = 0.55;
sfxDecline.volume = 0.50;
sfxBack.volume    = 0.50;

let lastHoverTime = 0;

// Fungsi pemutar audio dengan clone node agar tidak saling memotong
function playSfx(audio) {
    if (!audio) return;
    const sound = audio.cloneNode();
    sound.volume = audio.volume;
    sound.play().catch(() => {});
}

// Menahan perpindahan halaman sesaat agar audio terdengar sampai selesai
function handleNavigationWithSfx(e, element, audio, delayMs = 200) {
    playSfx(audio);

    // Jika elemen berupa tautan (<a>)
    if (element.tagName && element.tagName.toLowerCase() === 'a' && element.href && !element.href.startsWith('javascript:')) {
        e.preventDefault();
        setTimeout(() => {
            window.location.href = element.href;
        }, delayMs);
        return;
    }

    // Jika elemen berupa tombol submit di dalam form (selain form hapus)
    if (element.type === 'submit' && element.form) {
        e.preventDefault();
        const form = element.form;
        setTimeout(() => {
            HTMLFormElement.prototype.submit.call(form);
        }, delayMs);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // EFEK HOVER (hover.wav)
    const hoverTargets = 'tbody tr, .btn, .form-control, .page-link, thead th';
    document.querySelectorAll(hoverTargets).forEach(el => {
        el.addEventListener('mouseenter', () => {
            const now = Date.now();
            if (now - lastHoverTime > 45) {
                playSfx(sfxHover);
                lastHoverTime = now;
            }
        });
    });

    // EFEK FOCUS INPUT & CHANGE DROPDOWN
    // Saat kursor masuk/klik kolom input text atau angka
    document.querySelectorAll('input.form-control, textarea.form-control').forEach(el => {
        el.addEventListener('focus', () => {
            playSfx(sfxHover);
        });
    });

    // Saat memilih opsi pada dropdown (select)
    document.querySelectorAll('select.form-control').forEach(el => {
        el.addEventListener('change', () => {
            playSfx(sfxDecide);
        });
    });

    // Cek apakah tombol/tautan berfungsi sebagai "KEMBALI"
    function isBackButton(el) {
        if (el.classList.contains('btn-secondary')) return true;
        const text = el.textContent.trim().toUpperCase();
        return text.includes('KEMBALI') || text.includes('BACK') || text.includes('RETURN');
    }

    //  EFEK KEMBALI (back.wav)
    document.querySelectorAll('a.btn, button.btn').forEach(el => {
        if (isBackButton(el)) {
            el.addEventListener('click', (e) => {
                handleNavigationWithSfx(e, el, sfxBack, 200);
            });
        }
    });

    // Tombol reset
    document.querySelectorAll('button[type="reset"]').forEach(el => {
        el.addEventListener('click', () => {
            playSfx(sfxBack);
        });
    });

    // EFEK MEMILIH / DECIDE (decide.wav)
    const decideLinks = 'a.btn-primary, a.btn-success, a.btn-dark, .page-link';
    document.querySelectorAll(decideLinks).forEach(el => {
        if (!isBackButton(el)) {
            el.addEventListener('click', (e) => {
                handleNavigationWithSfx(e, el, sfxDecide, 600);
            });
        }
    });

    // Tombol simpan/update form
    const submitButtons = 'form:not(.form-delete) button[type="submit"]';
    document.querySelectorAll(submitButtons).forEach(el => {
        el.addEventListener('click', (e) => {
            if (el.form && el.form.checkValidity && !el.form.checkValidity()) {
                playSfx(sfxDecide);
                return;
            }
            handleNavigationWithSfx(e, el, sfxDecide, 600);
        });
    });

    // HAPUS / PERINGATAN (decline.wav, decide.wav, & back.wav)
    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            playSfx(sfxDecline);

            setTimeout(() => {
                const confirmed = confirm('PERINGATAN SISTEM: Apakah Anda yakin ingin menghapus data mahasiswa ini?');
                if (confirmed) {
                    playSfx(sfxDecide);
                    setTimeout(() => {
                        HTMLFormElement.prototype.submit.call(form);
                    }, 200);
                } else {
                    playSfx(sfxBack);
                }
            }, 120);
        });
    });
});
