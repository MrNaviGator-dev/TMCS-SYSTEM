--
-- PostgreSQL database dump
--

\restrict v6AcZde5W0EhTXaCRqTxKvR63XY2UjcAqcbzqbhf6LrWtRc1Z7sddPFlWfK0Kr5

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

--
-- Name: accounts_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.accounts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.accounts_id_seq OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: accounts; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.accounts (
    id bigint DEFAULT nextval('public.accounts_id_seq'::regclass) NOT NULL,
    account_type character varying(20) NOT NULL,
    account_number character varying(30) NOT NULL,
    account_name character varying(100) NOT NULL,
    status character varying(20) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    network_bank character varying(100),
    CONSTRAINT accounts_account_type_check CHECK (((account_type)::text = ANY (ARRAY[('mobile'::character varying)::text, ('bank'::character varying)::text]))),
    CONSTRAINT accounts_status_check CHECK (((status)::text = ANY (ARRAY[('active'::character varying)::text, ('inactive'::character varying)::text])))
);


ALTER TABLE public.accounts OWNER TO postgres;

--
-- Name: announcements; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.announcements (
    id bigint NOT NULL,
    title character varying(255) NOT NULL,
    message text NOT NULL,
    priority character varying(20) DEFAULT 'normal'::character varying,
    audience character varying(20) DEFAULT 'all'::character varying,
    status character varying(20) DEFAULT 'active'::character varying,
    expiry_date date,
    image text,
    created_by bigint,
    updated_by bigint,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT announcements_audience_check CHECK (((audience)::text = ANY ((ARRAY['all'::character varying, 'members'::character varying, 'leaders'::character varying, 'admins'::character varying, 'executive'::character varying])::text[]))),
    CONSTRAINT announcements_priority_check CHECK (((priority)::text = ANY ((ARRAY['normal'::character varying, 'important'::character varying, 'urgent'::character varying])::text[]))),
    CONSTRAINT announcements_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying, 'expired'::character varying])::text[])))
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
    phone_number character varying(255),
    gender character varying(255),
    home_diocese character varying(255),
    year_of_study character varying(255),
    role character varying(255) DEFAULT 'user'::character varying NOT NULL,
    registration_number character varying(255),
    profile_picture character varying(255),
    membership_status character varying(255) DEFAULT 'Active'::character varying NOT NULL,
    registration_date date,
    forgot_otp character varying(255),
    forgot_otp_expires_at timestamp(0) without time zone
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
-- Data for Name: accounts; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.accounts (id, account_type, account_number, account_name, status, created_at, network_bank) FROM stdin;
13	mobile	37143399	Watson Boniface	active	2026-04-08 17:51:04.50647	Mixx By Yas
12	bank	012345678901209	Roman Catholic - Tz	active	2026-04-08 17:40:34.780532	NBC
\.


--
-- Data for Name: announcements; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.announcements (id, title, message, priority, audience, status, expiry_date, image, created_by, updated_by, created_at, updated_at) FROM stdin;
1	TANGAZO TANGAZO TANGAZO	Mfumo wetu umerejea kwa sasa wote ingieni kwenye account zenu na mu update level za elimu	normal	all	active	2026-05-01	announcements/1775648619_69d63f6b52158.jpg	18	18	2026-04-08 11:43:39	2026-04-08 11:43:39
2	NEW UPDATES	All members lets meets room 11 Irrigation at noo	urgent	all	active	2026-04-09	announcements/JhpAOY7z9MwEoDhJkSZrcAYMUmecERCS4pVvRUgK.jpg	19	\N	2026-04-08 11:48:21	2026-04-08 11:48:21
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
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2024_03_15_000000_add_profile_fields_to_users_table	1
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
27	2026_02_08_154413_add_payment_reference_columns_to_accounts_table	6
28	2026_02_10_182456_add_avatar_column_to_users_table	6
29	2026_03_28_115741_add_forgot_otp_columns_to_users_table	6
30	2026_04_08_115836_add_network_bank_to_accounts_table	7
31	2026_04_08_000001_add_forgot_otp_fields_to_users_table	8
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
1	18	membership	2000.00	Membership fee payment for 2026 (Full payment)	mobile_money	John Mariseli	full	2026	payment_proofs/1775643503_a31b7c6a-e78f-4edb-90f8-a76d66d07772.jpg	completed	2026-04-08 10:18:24	2026-04-08 10:18:24
5	17	membership	2000.00	Paid\n\nAdmin Approval Comments: Full Paid	mobile_4	subira John	full	2027	payments/payment_1775644272_69d62e702e6be.jpg	completed	2026-04-08 10:31:12	2026-04-08 10:32:21
4	17	zaka	2000.00	Full Payment: Paying the complete membership fee of TZS 2,000\n\nAdmin Approval Comments: Full Paid	mobile_4	subira kalinga	full	2026	payments/payment_1775643922_69d62d12a7d0c.jpg	completed	2026-04-08 10:25:22	2026-04-08 10:32:44
2	17	membership	2000.00	Full Payment: Paying the complete membership fee of TZS 2,000. No further payments required.\n\nAdmin Approval Comments: Full Paid	mobile_4	subira kalinga	full	2026	payments/payment_1775643657_69d62c0902a93.jpg	completed	2026-04-08 10:20:57	2026-04-08 10:32:52
3	19	membership	2000.00	paid\n\nAdmin Approval Comments: Full Paid	4	Manase Mitingi	full	2026	payments/payment_1775643800_69d62c986b99d.jpg	completed	2026-04-08 10:23:20	2026-04-08 10:33:02
6	18	certificate	4000.00	Certificate fee payment for 2026 (Full payment)	mobile_money	John Mariseli	full	2026	payment_proofs/1775647230_2nd yr.jpg	completed	2026-04-08 11:20:30	2026-04-08 11:20:30
8	17	certificate	4000.00	Paid	mobile_4	subira kalinga	full	2026	payments/payment_1775647847_69d63c678728d.jpg	completed	2026-04-08 11:30:47	2026-04-08 11:32:17
7	19	certificate	4000.00	Paid	4	Manase Mitingi	full	2026	payments/payment_1775647425_69d63ac11c3d1.jpg	completed	2026-04-08 11:23:45	2026-04-08 11:32:29
9	17	membership	2000.00	Full Paid\n\nRejection Reason: Not Full Paid	mobile_13	subira kalinga	full	2026	payments/payment_1775666586_69d6859a84b72.jpg	rejected	2026-04-08 16:43:06	2026-04-08 16:44:10
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

COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at, phone_number, gender, home_diocese, year_of_study, role, registration_number, profile_picture, membership_status, registration_date, forgot_otp, forgot_otp_expires_at) FROM stdin;
18	John Silvester	johnmariseli7@gmail.com	\N	$2y$12$aw/UOlPlPzHQSF7DLpVEwuWxILOT.vpJR/cdZeDGye9dMVrw5Zgby	\N	2026-04-07 17:34:47	2026-04-08 15:22:53	255718772801	Male	Roman Catholic	Year 1	admin	TMCS/2019/2023	1775661773_JOHN.jpg	Active	\N	\N	\N
16	Watson Boniface	watsonboniface90@yahoo.com	\N	$2y$12$vpYqBrSyp0c1aBzWqhMZnun2UhQSmLyIkEhLYWNRJnqVifvubsWRO	\N	2026-04-07 17:10:44	2026-04-08 17:05:26	255716294829	Male	Roman Catholic	Graduate	admin	20211015021	1775581844_12345.jpg	Active	\N	0912	2026-04-08 17:15:26
17	Subira Kalinga	watsonhuruma14@gmail.com	\N	$2y$12$zXeExzizGVrrdzCcN02CXOo1YwkHuOiBxbKAM4L9antohEJ.KA14u	\N	2026-04-07 17:32:07	2026-04-08 17:14:05	255716294801	Female	Roman Catholic	Year 3	member	TMCS/0008/2026	1775583127_421.jpg	Active	2026-04-07	3674	2026-04-08 17:24:05
19	Manase Mitingi	godfreyboniface11@gmail.com	\N	$2y$12$6Mq5QnAZL/iPFMIniMOT3enroAVlM6v9W.Ol5P8PKhVY2G0I0Eu/6	\N	2026-04-07 17:54:53	2026-04-08 17:17:38	255716294802	Male	Roman Catholic	Year 1	leader	TMCS/0001/2019	1775666522_69d6855a85554.jpg	Active	2026-04-07	\N	\N
\.


--
-- Name: accounts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.accounts_id_seq', 13, true);


--
-- Name: announcements_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.announcements_id_seq', 2, true);


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

SELECT pg_catalog.setval('public.migrations_id_seq', 31, true);


--
-- Name: payments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.payments_id_seq', 9, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 19, true);


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
-- Name: announcements announcements_created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.announcements
    ADD CONSTRAINT announcements_created_by_fkey FOREIGN KEY (created_by) REFERENCES public.users(id);


--
-- Name: announcements announcements_updated_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.announcements
    ADD CONSTRAINT announcements_updated_by_fkey FOREIGN KEY (updated_by) REFERENCES public.users(id);


--
-- PostgreSQL database dump complete
--

\unrestrict v6AcZde5W0EhTXaCRqTxKvR63XY2UjcAqcbzqbhf6LrWtRc1Z7sddPFlWfK0Kr5

