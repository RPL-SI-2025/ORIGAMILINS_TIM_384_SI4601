<footer>
    <div class="footer-container">
        <div class="footer-brand">
            <div class="footer-brand-title">Origamilins.</div>
            <div class="footer-address">
                Jl. Cimendong No.3, Sukamaju, Kec. Cibeunying Kidul,<br>
                Kota Bandung, Jawa Barat 40121
            </div>
            <div class="social-links">
                <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
        <div class="footer-links">
            <div class="footer-link-group">
                <a href="/tentang" class="footer-link footer-link-primary">Tentang Kami</a>
                <a href="/layanan" class="footer-link">Layanan</a>
                <a href="/blog" class="footer-link">Blog</a>
            </div>
            <div class="footer-link-group">
                <a href="/dukungan" class="footer-link footer-link-primary">Dukung Kami</a>
                <a href="/kontak" class="footer-link">Kontak Kami</a>
            </div>
            <div class="footer-link-group">
                <a href="/karir" class="footer-link footer-link-primary">Lowongan</a>
                <a href="/tim" class="footer-link">Tim Kami</a>
                <a href="/privasi" class="footer-link">Privasi</a>
            </div>
            <div class="footer-link-group">
                <a href="/katalog" class="footer-link footer-link-primary">Katalog</a>
                <a href="/promo" class="footer-link">Promo</a>
                <a href="/event" class="footer-link">Informasi Event</a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div>
            © Copyright {{ date('Y') }} Koperasi Origami Indonesia, Inc. All rights reserved.
        </div>
        <div style="display:flex; gap:1.5rem;">
            <a href="/terms" class="footer-bottom-link">Terms & Conditions</a>
            <a href="/privacy" class="footer-bottom-link">Privacy Policy</a>
        </div>
    </div>
</footer>

<style>
footer {
    background: #fff;
    border-top: 2px solid #FFC107;
    box-shadow: 0 -2px 24px 0 rgba(8,53,216,0.04);
    font-family: 'Poppins', Arial, sans-serif;
    padding: 2.2rem 1rem 0.7rem 1rem;
    width: 100%;
}

.footer-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
    align-items: flex-start;
    justify-content: space-between;
    padding: 0 1rem;
}

.footer-brand {
    min-width: 220px;
    flex: 1;
}

.footer-brand-title {
    font-size: 2rem;
    font-weight: 700;
    color: #FFC107;
    margin-bottom: 0.5rem;
    letter-spacing: 1px;
}

.footer-address {
    color: #666;
    font-size: 1rem;
    margin-bottom: 1.3rem;
    line-height: 1.5;
}

.social-links {
    display: flex;
    gap: 0.7rem;
}

.social-link {
    background: #f7f7f7;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #0835d8;
    box-shadow: 0 1px 4px rgba(8,53,216,0.07);
    transition: background 0.2s;
    text-decoration: none;
}

.social-link:hover {
    background: #0835d8;
    color: #fff;
}

.footer-links {
    display: flex;
    flex: 2;
    flex-wrap: wrap;
    gap: 2.5rem;
    justify-content: flex-end;
}

.footer-link-group {
    min-width: 120px;
}

.footer-link {
    display: block;
    color: #666;
    margin-bottom: 0.5rem;
    text-decoration: none;
}

.footer-link-primary {
    color: #0835d8;
    font-weight: 500;
}

.footer-bottom {
    width: 100%;
    max-width: 1200px;
    margin: 1.2rem auto 0 auto;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    color: #888;
    font-size: 0.97rem;
    border-top: 1px solid #f0f0f0;
    padding: 0.7rem 1rem 0 1rem;
}

.footer-bottom-link {
    color: #888;
    text-decoration: none;
}

/* Responsive styles */
@media (max-width: 768px) {
    .footer-container {
        flex-direction: column;
        gap: 1.5rem;
        padding: 0;
    }

    .footer-brand {
        width: 100%;
        text-align: center;
    }

    .footer-links {
        width: 100%;
        justify-content: center;
        gap: 1.5rem;
    }

    .footer-link-group {
        text-align: center;
    }

    .footer-bottom {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }

    .footer-bottom > div {
        width: 100%;
    }
}

@media (max-width: 480px) {
    .footer-links {
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .footer-link-group {
        width: 100%;
    }
}
</style>