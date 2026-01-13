@extends('frontend.layouts.app')

@section('title', 'Al-Noor | Premium Islamic Store')
<style>
    /* Attar page specific styles - core layout and widgets are defined in the main layout */

    /* --- Page Header --- */
    .page-header {
        background: linear-gradient(rgba(15, 61, 40, 0.85), rgba(15, 61, 40, 0.7)), url('https://picsum.photos/seed/desertnight/1920/600');
        background-size: cover;
        background-position: center;
        padding: 100px 0;
        color: #fff;
        text-align: center;
    }

    /* --- Sidebar Filters --- */
    .filter-sidebar {
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        height: fit-content;
    }

    .filter-title {
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #eee;
        color: var(--primary);
    }

    .list-group-item {
        border: none;
        padding: 8px 15px;
        color: #666;
    }

    .list-group-item:hover {
        background-color: transparent;
        color: var(--primary);
        padding-left: 20px;
    }

    .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .price-range {
        width: 100%;
    }

    /* --- Scent Notes --- */
    .scent-note-card {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        border: 1px solid #eee;
    }

    .scent-note-card i {
        font-size: 2rem;
        margin-bottom: 10px;
    }

    .top-note i { color: #e17055; }
    .mid-note i { color: #fdcb6e; }
    .base-note i { color: #2d3436; }
</style>

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="row">

                <!-- Sidebar Filters -->
                <aside class="col-lg-3 mb-4">
                    <div class="filter-sidebar">
                        <div class="filter-title">Categories</div>
                        <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item d-flex justify-content-between align-items-center active">
                                All Attars <span class="badge bg-light text-dark rounded-pill">42</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Oudh & Agarwood <span class="badge bg-light text-dark rounded-pill">12</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Floral & Musk <span class="badge bg-light text-dark rounded-pill">18</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Oriental Spices <span class="badge bg-light text-dark rounded-pill">8</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Royal Collections <span class="badge bg-light text-dark rounded-pill">4</span>
                            </li>
                        </ul>

                        <div class="filter-title">Price Range</div>
                        <input type="range" class="form-range price-range mb-2" min="0" max="100">
                        <div class="d-flex justify-content-between small text-muted mb-4">
                            <span>$10</span>
                            <span>$200+</span>
                        </div>

                        <div class="filter-title">Scent Notes</div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" value="" id="note1">
                            <label class="form-check-label" for="note1">Woody</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" value="" id="note2">
                            <label class="form-check-label" for="note2">Floral</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" value="" id="note3">
                            <label class="form-check-label" for="note3">Spicy</label>
                        </div>

                        <button class="btn btn-dark w-100 mt-4 rounded-pill">Apply Filters</button>
                    </div>
                </aside>

                <!-- Product Grid -->
                <main class="col-lg-9">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="text-muted">Showing 9 of 42 results</span>
                        <select class="form-select w-auto border-0 bg-light">
                            <option>Sort by: Popularity</option>
                            <option>Sort by: Price: Low to High</option>
                            <option>Sort by: Price: High to Low</option>
                        </select>
                    </div>

                    <div class="row">
                        <!-- Product 1 -->
                        <div class="col-md-6 col-lg-4">
                            <div class="product-card">
                                <div class="product-img-wrapper">
                                    <img src="https://picsum.photos/seed/oudhroyal/400/400" alt="Royal Oudh">
                                    <div class="product-actions">
                                        <button class="action-btn"><i class="fas fa-shopping-cart"></i></button>
                                        <button class="action-btn"><i class="far fa-eye"></i></button>
                                    </div>
                                </div>
                                <div class="p-3 text-center">
                                    <div class="text-warning small mb-1"><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i></div>
                                    <h5 class="fw-bold">Royal Cambodi Oudh</h5>
                                    <p class="text-muted small">Deep, woody, and smoky</p>
                                    <span class="fs-5 fw-bold" style="color: var(--primary);">$45.00</span>
                                </div>
                            </div>
                        </div>

                        <!-- Product 2 -->
                        <div class="col-md-6 col-lg-4">
                            <div class="product-card">
                                <div class="product-img-wrapper">
                                    <span
                                        class="position-absolute top-0 end-0 bg-danger text-white m-2 px-2 py-1 rounded small">Sale</span>
                                    <img src="https://picsum.photos/seed/roseattar/400/400" alt="Rose Attar">
                                    <div class="product-actions">
                                        <button class="action-btn"><i class="fas fa-shopping-cart"></i></button>
                                        <button class="action-btn"><i class="far fa-eye"></i></button>
                                    </div>
                                </div>
                                <div class="p-3 text-center">
                                    <div class="text-warning small mb-1"><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="far fa-star"></i></div>
                                    <h5 class="fw-bold">Taif Rose</h5>
                                    <p class="text-muted small">Fresh, romantic, floral</p>
                                    <span class="fs-5 fw-bold text-decoration-line-through text-muted me-2">$30.00</span>
                                    <span class="fs-5 fw-bold" style="color: var(--primary);">$24.00</span>
                                </div>
                            </div>
                        </div>

                        <!-- Product 3 -->
                        <div class="col-md-6 col-lg-4">
                            <div class="product-card">
                                <div class="product-img-wrapper">
                                    <img src="https://picsum.photos/seed/musk/400/400" alt="White Musk">
                                    <div class="product-actions">
                                        <button class="action-btn"><i class="fas fa-shopping-cart"></i></button>
                                        <button class="action-btn"><i class="far fa-eye"></i></button>
                                    </div>
                                </div>
                                <div class="p-3 text-center">
                                    <div class="text-warning small mb-1"><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i></div>
                                    <h5 class="fw-bold">White Musk</h5>
                                    <p class="text-muted small">Clean, soft, powdering</p>
                                    <span class="fs-5 fw-bold" style="color: var(--primary);">$18.00</span>
                                </div>
                            </div>
                        </div>

                        <!-- Product 4 -->
                        <div class="col-md-6 col-lg-4">
                            <div class="product-card">
                                <div class="product-img-wrapper">
                                    <img src="https://picsum.photos/seed/amber/400/400" alt="Amber">
                                    <div class="product-actions">
                                        <button class="action-btn"><i class="fas fa-shopping-cart"></i></button>
                                        <button class="action-btn"><i class="far fa-eye"></i></button>
                                    </div>
                                </div>
                                <div class="p-3 text-center">
                                    <div class="text-warning small mb-1"><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star-half-alt"></i><i class="far fa-star"></i></div>
                                    <h5 class="fw-bold">Golden Amber</h5>
                                    <p class="text-muted small">Warm, sweet, resinous</p>
                                    <span class="fs-5 fw-bold" style="color: var(--primary);">$32.00</span>
                                </div>
                            </div>
                        </div>

                        <!-- Product 5 -->
                        <div class="col-md-6 col-lg-4">
                            <div class="product-card">
                                <div class="product-img-wrapper">
                                    <img src="https://picsum.photos/seed/sandalwood/400/400" alt="Sandalwood">
                                    <div class="product-actions">
                                        <button class="action-btn"><i class="fas fa-shopping-cart"></i></button>
                                        <button class="action-btn"><i class="far fa-eye"></i></button>
                                    </div>
                                </div>
                                <div class="p-3 text-center">
                                    <div class="text-warning small mb-1"><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i></div>
                                    <h5 class="fw-bold">Mysore Sandalwood</h5>
                                    <p class="text-muted small">Creamy, milky, sacred</p>
                                    <span class="fs-5 fw-bold" style="color: var(--primary);">$55.00</span>
                                </div>
                            </div>
                        </div>

                        <!-- Product 6 -->
                        <div class="col-md-6 col-lg-4">
                            <div class="product-card">
                                <div class="product-img-wrapper">
                                    <span
                                        class="position-absolute top-0 end-0 bg-primary text-white m-2 px-2 py-1 rounded small">New</span>
                                    <img src="https://picsum.photos/seed/jasmine/400/400" alt="Jasmine">
                                    <div class="product-actions">
                                        <button class="action-btn"><i class="fas fa-shopping-cart"></i></button>
                                        <button class="action-btn"><i class="far fa-eye"></i></button>
                                    </div>
                                </div>
                                <div class="p-3 text-center">
                                    <div class="text-warning small mb-1"><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="far fa-star"></i></div>
                                    <h5 class="fw-bold">Arabian Jasmine</h5>
                                    <p class="text-muted small">Intoxicating, sweet bloom</p>
                                    <span class="fs-5 fw-bold" style="color: var(--primary);">$22.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation" class="mt-5">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item active"><a class="page-link bg-dark border-dark" href="#">1</a>
                            </li>
                            <li class="page-item"><a class="page-link text-dark" href="#">2</a></li>
                            <li class="page-item"><a class="page-link text-dark" href="#">3</a></li>
                            <li class="page-item"><a class="page-link text-dark" href="#">Next</a></li>
                        </ul>
                    </nav>
                </main>
            </div>
        </div>
    </section>

    <!-- Scent Guide Section (Educational) -->
    <section class="bg-white py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h6 class="text-uppercase text-muted">Understanding Fragrance</h6>
                <h2 style="color: var(--primary);">The Scent Pyramid</h2>
                <p class="text-muted">Attars evolve on your skin. Discover the journey of our fragrances.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="scent-note-card top-note h-100">
                        <i class="fas fa-leaf"></i>
                        <h4>Top Notes</h4>
                        <p class="text-muted">The initial impression. Fresh, light, and volatile scents that evaporate
                            quickly. Think citrus or light spices.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="scent-note-card mid-note h-100">
                        <i class="fas fa-fan"></i>
                        <h4>Heart Notes</h4>
                        <p class="text-muted">The core of the fragrance. Appears after the top notes fade. Usually florals
                            like rose, jasmine, or herbs.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="scent-note-card base-note h-100">
                        <i class="fas fa-tree"></i>
                        <h4>Base Notes</h4>
                        <p class="text-muted">The lasting impression. Deep and rich woods, musk, or amber that stay on the
                            skin for hours.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
