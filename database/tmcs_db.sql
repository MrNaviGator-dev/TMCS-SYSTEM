--
-- PostgreSQL database dump
--

\restrict wZBycFXzuay2BgYDFl7tcvG9z92vq13ZDNC0GG0JkNQH5XsRRlPB8JuKiwfLyLZ

-- Dumped from database version 18.1
-- Dumped by pg_dump version 18.1

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: announcements; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.announcements (
    id bigint NOT NULL,
    title character varying(255) NOT NULL,
    content text NOT NULL,
    type character varying(255) DEFAULT 'general'::character varying NOT NULL,
    priority character varying(255) DEFAULT 'medium'::character varying NOT NULL,
    status character varying(255) DEFAULT 'active'::character varying NOT NULL,
    starts_at timestamp(0) without time zone,
    ends_at timestamp(0) without time zone,
    created_by bigint NOT NULL,
    target_audience character varying(255) DEFAULT 'all'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.announcements OWNER TO postgres;

--
-- Name: announcements_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.announcements_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.announcements_id_seq OWNER TO postgres;

--
-- Name: announcements_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.announcements_id_seq OWNED BY public.announcements.id;


--
-- Name: cache; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO postgres;

--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO postgres;

--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO postgres;

--
-- Name: jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jobs_id_seq OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- Name: payments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.payments (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    payment_type character varying(255) NOT NULL,
    amount numeric(10,2) NOT NULL,
    description text NOT NULL,
    payment_method character varying(100) NOT NULL,
    sender_name character varying(255) NOT NULL,
    installment_type character varying(50),
    payment_year integer NOT NULL,
    attachment character varying(255),
    status character varying(20) DEFAULT 'pending'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.payments OWNER TO postgres;

--
-- Name: payments_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.payments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.payments_id_seq OWNER TO postgres;

--
-- Name: payments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.payments_id_seq OWNED BY public.payments.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO postgres;

--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    role character varying(255) DEFAULT 'member'::character varying NOT NULL,
    registration_number character varying(255),
    home_diocese character varying(255),
    phone_number character varying(255),
    profile_picture character varying(255),
    registration_date timestamp(0) without time zone,
    gender character varying(255),
    year_of_study character varying(255),
    address text,
    date_of_birth date,
    membership_status character varying(255) DEFAULT 'pending'::character varying NOT NULL
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: announcements id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.announcements ALTER COLUMN id SET DEFAULT nextval('public.announcements_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: payments id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments ALTER COLUMN id SET DEFAULT nextval('public.payments_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: announcements; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.announcements (id, title, content, type, priority, status, starts_at, ends_at, created_by, target_audience, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
14	0001_01_01_000000_create_users_table	1
15	0001_01_01_000001_create_cache_table	1
16	0001_01_01_000002_create_jobs_table	1
17	2026_01_24_062952_add_role_to_users_table	1
18	2026_01_24_085535_add_student_fields_to_users_table	1
19	2026_01_24_133000_add_registration_date_to_users_table	1
20	2026_01_24_134000_update_registration_date_for_existing_users	1
21	2026_01_27_104038_add_address_and_date_of_birth_to_users_table	1
22	2026_02_02_073833_add_missing_user_fields	2
24	2026_02_02_081453_add_missing_columns_to_payment_accounts	3
25	2026_02_03_082352_create_payments_table	4
26	2026_02_04_211102_create_announcements_table	5
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: payments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.payments (id, user_id, payment_type, amount, description, payment_method, sender_name, installment_type, payment_year, attachment, status, created_at, updated_at) FROM stdin;
2	3	membership	2000.00	2000\n\nAdmin Approval Comments: Full Paid	mobile_money_1	subira kalinga	\N	2026	payments/payment_1770110403_8d235869-4b67-4862-9262-ac7842a25967.jpg	completed	2026-02-03 09:20:03	2026-02-05 12:41:55
1	3	certificate	4000.00	4000\n\nAdmin Approval Comments: Full Paid	mobile_money_1	subira kalinga	\N	2026	payments/payment_1770107491_8d235869-4b67-4862-9262-ac7842a25967.jpg	completed	2026-02-03 08:31:31	2026-02-05 12:46:33
3	3	zaka	2000.00	2000\n\nRejection Reason: Resend attachment proof	mobile_money_1	subira kalinga	\N	2026	payments/payment_1770110439_8d235869-4b67-4862-9262-ac7842a25967.jpg	rejected	2026-02-03 09:20:39	2026-02-05 13:14:48
4	3	zaka	2000.00	2000\n\nAdmin Approval Comments: Full Paid	mobile_money_1	subira kalinga	full	2026	payments/payment_1770297507_2nd yr.jpg	completed	2026-02-05 13:18:28	2026-02-05 13:19:16
5	4	certificate	4000.00	4000\n\nAdmin Approval Comments: Full paid	bank_6	Manase Mitingi	\N	2026	payments/payment_1770301358_11 copy.jpg	completed	2026-02-05 14:22:39	2026-02-05 14:24:31
6	3	membership	2000.00	2000\n\nAdmin Approval Comments: Full claimed	mobile_money_1	subira kalinga	full	2027	payments/payment_1770302349_32.jpg	completed	2026-02-05 14:39:09	2026-02-05 14:40:48
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
vYWq9hwX2m8LdGdLRB3ULgNDgN75NQ5nyv3o7tZe	1	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36	YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSjRldXNSdEc5Z0xWM0pmMzBORG4wdlkwd2tkVERhalpBSGNmSXVPeiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wYXltZW50LWFjY291bnRzIjtzOjU6InJvdXRlIjtzOjI4OiJhZG1pbi5wYXltZW50LWFjY291bnRzLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9	1770459341
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at, role, registration_number, home_diocese, phone_number, profile_picture, registration_date, gender, year_of_study, address, date_of_birth, membership_status) FROM stdin;
1	John Silvester	johnmariseli7@gmail.com	\N	$2y$12$uGI85KpvP.7XH7Bw6xw20ujaN.wOsE1SCkEQxZ5CutaLH.ti3xOAq	\N	2026-02-02 07:40:18	2026-02-02 07:40:18	admin	TMCS/2019/2024	Roman Catholic	255718772801	1770018018_JOHN.jpg	\N	Male	Year 1	\N	\N	Active
3	Subira John	subirajohn@gmail.com	\N	$2y$12$PzHVS5FOZwIeK5FTMHGKfO9.YRuDg2oprTXU3qkw/ta6rM0fY61qW	\N	2026-02-02 07:56:55	2026-02-02 07:58:41	member	TMCS/0060/2018	Pentecostal	255716294801	1770019015_94fef6bd-ce49-41d4-9b15-5ec24e280d0a.jpg	\N	Female	Graduate	\N	\N	Active
2	Watson Boniface	watsonboniface90@yahoo.com	\N	$2y$12$tfctBzdXDNJQJse3R3p4F.J8zXt6gdIjmA2CGarIQ6hFSyDpl1R36	\N	2026-02-02 07:51:42	2026-02-02 07:59:10	leader	TMCS/0001/2019	Moravian	255716294829	1770018702_a712790d-e112-4bbe-a525-091b804f8c14.jpg	\N	Male	Graduate	\N	\N	Active
4	Manase Mitingi	manasemitingi@gmail.com	\N	$2y$12$cA/N0rOafgtClFybelQelObHqu6lZOz5.ynM4kywGFksi1C2in/Bq	\N	2026-02-02 07:58:14	2026-02-05 14:22:01	member	TMCS/2019/2023	Roman Catholic	255716294802	1770019094_RUN.jpg	\N	Male	Year 2	\N	\N	Active
5	Godfrey Boniface	godfreyboniface@gmail.com	\N	$2y$12$mt2D7OUUGpYKHZfZ2NV.JujloAR447L5rhcETwYWThq1rg2TUgjoe	\N	2026-02-05 17:44:02	2026-02-05 17:44:02	member	TMCS/2019/20299	Moravian	255716294803	1770313442_1c547e70-b6ef-4eaa-918d-18a65016e5fd.jpg	2026-02-05 17:44:02	Male	Year 2	\N	\N	Active
11	Peter Kibona	peterkib@gmail.com	\N	$2y$12$PLKDDooeX1JN73mQE620QeYqjuoC01QEngsxlthZOTBI68z8Zv82S	\N	2026-02-06 19:54:19	2026-02-06 19:54:19	leader	TMCS/2003/2001	Moravian	255716294808	1770407659_1c547e70-b6ef-4eaa-918d-18a65016e5fd.jpg	2026-02-06 19:54:19	Male	Year 2	\N	\N	Active
12	Oliva Boniface	olivabon@gmail.com	\N	$2y$12$B6QQuLdXr6P9.gY/BJ7i6.zWAZIjnd1JeOqy3Szi5J92cSAFl2E7e	\N	2026-02-06 20:01:09	2026-02-06 20:01:09	member	TMCS/2019/2027	Roman Catholic	255716294815	1770408069_1.jpg	2026-02-06 20:01:09	Female	Year 2	\N	\N	Active
13	Michael Charles	michaelcharles@gmail.com	\N	$2y$12$u0tUVYGRhM5ws8udNWpI9uJ/GaZSCKwEIc8BEhvz.JBnBbhpF5gLW	\N	2026-02-06 20:04:53	2026-02-06 20:04:53	admin	TMCS/2003/20063	Pentecostal	255718772803	1770408292_64ae0128-773a-4c28-b6bf-000573f42982.jpg	2026-02-06 20:04:53	Male	Year 2	\N	\N	Active
14	Amani Ndaga	aman@gmail.com	\N	$2y$12$JaSjzGaAW9PJGg0931heg.7cWHC72U1jWvmps7.TkqbXSgVf.ULUq	\N	2026-02-06 20:12:34	2026-02-06 20:12:34	member	1233/223/09	Roman Catholic	255716294810	1770408754_YISAMBI.jpg	2026-02-06 20:12:34	Male	Year 3	\N	\N	Active
15	mika Jax	mikajax@gmail.com	\N	$2y$12$cMC/9ly72Wkc8dviywYxu.Beg4AU/acR/lLO2.F08ImGZ0r70BMu.	\N	2026-02-06 20:16:04	2026-02-06 20:16:04	member	TMCS/2019/2000	TMCS	255710111213	1770408964_picha-removebg-preview.png	2026-02-06 20:16:04	Female	Graduate	\N	\N	Inactive
\.


--
-- Name: announcements_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.announcements_id_seq', 1, false);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 26, true);


--
-- Name: payments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.payments_id_seq', 6, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 15, true);


--
-- Name: announcements announcements_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.announcements
    ADD CONSTRAINT announcements_pkey PRIMARY KEY (id);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: payments payments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_pkey PRIMARY KEY (id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: users users_registration_number_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_registration_number_unique UNIQUE (registration_number);


--
-- Name: announcements_priority_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX announcements_priority_index ON public.announcements USING btree (priority);


--
-- Name: announcements_status_starts_at_ends_at_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX announcements_status_starts_at_ends_at_index ON public.announcements USING btree (status, starts_at, ends_at);


--
-- Name: announcements_target_audience_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX announcements_target_audience_index ON public.announcements USING btree (target_audience);


--
-- Name: cache_expiration_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cache_expiration_index ON public.cache USING btree (expiration);


--
-- Name: cache_locks_expiration_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cache_locks_expiration_index ON public.cache_locks USING btree (expiration);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: payments_created_at_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX payments_created_at_index ON public.payments USING btree (created_at);


--
-- Name: payments_payment_type_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX payments_payment_type_index ON public.payments USING btree (payment_type);


--
-- Name: payments_payment_year_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX payments_payment_year_index ON public.payments USING btree (payment_year);


--
-- Name: payments_status_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX payments_status_index ON public.payments USING btree (status);


--
-- Name: payments_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX payments_user_id_index ON public.payments USING btree (user_id);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: announcements announcements_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.announcements
    ADD CONSTRAINT announcements_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: payments payments_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

\unrestrict wZBycFXzuay2BgYDFl7tcvG9z92vq13ZDNC0GG0JkNQH5XsRRlPB8JuKiwfLyLZ

